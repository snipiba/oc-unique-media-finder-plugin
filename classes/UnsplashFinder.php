<?php
namespace SNiPI\UniqueMediaFinder\Classes;

use Storage;
use Cache;
use Input;
use BackendAuth;
use Carbon\Carbon;
use Http;
use SNIPI\UniqueMediaFinder\Models\Settings;
use SNIPI\UniqueMediaFinder\Models\MetadataInformations;
use SNIPI\UniqueMediaFinder\Models\UnsplashPhoto;
use Session;
use kornrunner\Blurhash\Blurhash;

class UnsplashFinder implements FinderInterface {

	const UNSPLASH_API_ENDPOINT = 'https://api.unsplash.com';

	
	public function __construct() {
		if(empty(Settings::get('unsplash_api_key'))) {
			return;
		}         
	}

	public function configured():bool {
		return empty(Settings::get('unsplash_api_key')) ? false : true;
	}

	
	/**
	 * @param string $query search query string
	 * @param int $per_page limit results per page
	 * @param int $page current page
	 *
	 * @return array
	 */
	public function search(string $query, array $options, int $page = 1):array
	{
		$per_page = Settings::get('unsplash_per_page') ?? 12;
		$safeSearch = (array_key_exists('content_filter', $options)) ? 'high' : 'low';
		$orientation = '';
		if(array_key_exists('orientation', $options)) {
			if($options['orientation'] !== 'all') {
				$orientation = '&orientation=';
				if($options['orientation'] == 'square') {
					$orientation .= 'squarish';
				} else {
					$orientation .= $options['orientation'];
				}
			}
		}
		$cacheKey = str_slug($query).'/'.$page.'/'.$safeSearch.'/'.$per_page.'/'.$orientation;
		
		if(!Cache::has($cacheKey)) {
			$data = Http::get(self::UNSPLASH_API_ENDPOINT . '/search/photos/?page=' . $page . $orientation .'&content_filter='.$safeSearch.'&query=' . urlencode($query) .'&per_page=' . $per_page, function($http){
				$http->header('Authorization', 'Client-ID '.Settings::get('unsplash_api_key'));
				$http->header('Accept-Version','v1');    
			});
			Cache::put($cacheKey, ['headers' => $data->headers,'body' => $data->body], Carbon::now()->addMinutes(60));			
		}
		$cached = Cache::get($cacheKey);
		$this->updateLimits($cached['headers']);
		$photoData = json_decode($cached['body'], true);
		return $photoData;
	}

	/**
	 * @param string $photoIdentifier unique ID of photo
	 *
	 * @return UnsplashPhoto
	 */ 
	public function getPhoto(string $photoIdentifier): array
	{
		$data = Http::get(self::UNSPLASH_API_ENDPOINT . '/photos/' . $photoIdentifier, function($http){
			$http->header('Authorization', 'Client-ID '.Settings::get('unsplash_api_key'));
			$http->header('Accept-Version','v1');    
		});
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		if(!is_null($photoData['blur_hash'])) {
			$photoData['blur_hash_image'] = $this->getBlurHashImage($photoData['blur_hash']);
		}
		return $photoData;
	}
	public function downloadPhoto(string $photoIdentifier): bool
	{
		$data = Http::get(self::UNSPLASH_API_ENDPOINT . '/photos/' . $photoIdentifier .'/download', function($http){
			$http->header('Authorization', 'Client-ID '.Settings::get('unsplash_api_key'));
			$http->header('Accept-Version','v1');    
		});

		$photoData = Http::get(self::UNSPLASH_API_ENDPOINT . '/photos/' . $photoIdentifier, function($http){
			$http->header('Authorization', 'Client-ID '.Settings::get('unsplash_api_key'));
			$http->header('Accept-Version','v1');    
		});
		$rawPhotoData = json_decode($photoData->body);
		$this->updateLimits($data->headers);
		$raw = json_decode($data->body);

		if(!empty($raw->url)) {
			
			$rawData = Http::get($raw->url);
			$pi = pathinfo($raw->url);
			if(!Storage::exists('media/' . Settings::get('unsplash_upload_folder'))) {
				Storage::makeDirectory('media/' . Settings::get('unsplash_upload_folder'));
			}
			$filename = 'unsplash_' . $photoIdentifier.'.jpg';
			$file =Storage::put('media/' . Settings::get('unsplash_upload_folder') .'/'.$filename,
				$rawData->body
			);

			if($file) {
				if(Settings::get('store_metadata')) {
					$meta = new MetadataInformations;
					$meta->filename = $filename;
					$meta->raw_data = $rawPhotoData;
					$meta->full_path = '/' . Settings::get('unsplash_upload_folder') .'/' .$filename;
					$meta->author = $rawPhotoData->user->name;
					$meta->provider = 'unsplash';
					$meta->user_id = BackendAuth::getUser()->id;
					$meta->save();					
				}
			}
			return true;
		} 
		return false;
	}

	public function loadRandom(): array
	{
		$cacheKey = 'unsplash/random/12/1';
		if(!Cache::has($cacheKey)) {
			$response = Http::get(self::UNSPLASH_API_ENDPOINT . '/photos/random?count=12', function($http){
				$http->header('Authorization', 'Client-ID '.Settings::get('unsplash_api_key'));  
				$http->header('Accept-Version','v1');  
			});
			Cache::put($cacheKey, ['headers' => $response->headers,'body' => $response->body], Carbon::now()->addMinutes(10));
		}
		$cached = Cache::get($cacheKey);
		$this->updateLimits($cached['headers']);
		$photos = json_decode($cached['body'], true);
		return $photos;
	}

	protected function updateLimits($headers) {

		$settings = Settings::instance();
		$settings->unsplash_limit = $headers['x-ratelimit-limit'];
		$settings->unsplash_remain = $headers['x-ratelimit-remaining'];
		$settings->save();
	}

	protected function getBlurHashImage($blurhash, $width = 350, $height = 200) {
		ob_start ( ); // Start buffering
		$pixels = Blurhash::decode($blurhash, $width, $height);
		$image  = imagecreatetruecolor($width, $height);
		for ($y = 0; $y < $height; ++$y) {
		    for ($x = 0; $x < $width; ++$x) {
		        [$r, $g, $b] = $pixels[$y][$x];
		        imagesetpixel($image, $x, $y, imagecolorallocate($image, $r, $g, $b));
		    }
		}
		imagepng($image);
		$imageData = ob_get_contents ( ); // store image data
		ob_end_clean ( ); // end and clear buffer
		return base64_encode($imageData);		
	}

	public function blurHashBackground($hash, $width = 200, $height = 200) {
		ob_start ( ); // Start buffering
		$pixels = Blurhash::decode($hash, $width, $height);
		$image  = imagecreatetruecolor($width, $height);
		for ($y = 0; $y < $height; ++$y) {
		    for ($x = 0; $x < $width; ++$x) {
		        [$r, $g, $b] = $pixels[$y][$x];
		        imagesetpixel($image, $x, $y, imagecolorallocate($image, $r, $g, $b));
		    }
		}
		imagepng($image);
		$imageData = ob_get_contents ( ); // store image data
		ob_end_clean ( ); // end and clear buffer
		return 'data:image/png;base64,' . base64_encode($imageData);

	}

	public function getLimit() {
		return Settings::get('unsplash_limit');
	}

	public function getRemainig() {
		return Settings::get('unsplash_remain');
	}
}