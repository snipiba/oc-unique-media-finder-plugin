<?php

namespace SNiPI\UniqueMediaFinder\Classes;

use SNiPI\UniqueMediaFinder\Models\Settings;
use SNiPI\UniqueMediaFinder\Models\MetadataInformations;
use Storage;
use BackendAuth;
use Session;
use Http;

class PexelsFinder implements FinderInterface {
	
	const PEXELS_API_ENDPOINT = 'https://api.pexels.com/v1';

	public function __construct() {
		if(empty(Settings::get('pexels_api_key'))) {
			return;
		} 
	}

	public function configured():bool {
		return empty(Settings::get('pexels_api_key')) ? false : true;
	}

	public function isEnabled():bool {
		return empty(Settings::get('enable_pexels')) ? false : true;
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
		$per_page = Settings::get('pexels_per_page') ?? 10;
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
		$size = '';
		if(array_key_exists('size', $options) && $options['size'] != 'all') {
			$size = '&size=' . $options['size'];
		}
		$data = Http::get(self::PEXELS_API_ENDPOINT . '/search/?page=' . $page . $orientation . $size .'&query=' . urlencode($query) .'&per_page=' . $per_page, function($http){
			$http->header('Authorization', Settings::get('pexels_api_key'));
		});
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		$returnData = $photoData;
		$returnData['results'] = $photoData['photos'];
		unset($returnData['photos']);
		return $returnData;
	}

	/**
	 * @param string $photoIdentifier unique ID of photo
	 *
	 * @return PhotoInterface
	 */ 
	public function getPhoto(string $photoIdentifier): array
	{
		
		$data = Http::get(self::PEXELS_API_ENDPOINT . '/photos/' . $photoIdentifier, function($http){
			$http->header('Authorization', Settings::get('pexels_api_key'));
		});
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		return $photoData;
	}
	
	public function downloadPhoto(string $photoIdentifier): bool
	{
		$data = Http::get(self::PEXELS_API_ENDPOINT . '/photos/' . $photoIdentifier, function($http){
			$http->header('Authorization', Settings::get('pexels_api_key'));
		});
		$this->updateLimits($data->headers);
		$photo = json_decode($data->body, true);
		if($photo) {

			$size = Settings::get('pexels_default_download_quality', 'original');
			$pathToDownload = $photo['src'][$size];
			$pi = pathinfo($pathToDownload);			
			$rawData = Http::get($pathToDownload);	
			if(!Storage::exists('media/' . Settings::get('pexels_upload_folder'))) {
				Storage::makeDirectory('media/' . Settings::get('pexels_upload_folder'));
			}
			$ext = explode('?', $pi['extension'])[0];
			$filename = $size .'_'.$pi['filename'].'.'.$ext;
			$file =Storage::put('media/' . Settings::get('pexels_upload_folder') .'/' . $filename,
				$rawData->body
			);
			if($file) {
				if(Settings::get('store_metadata')) {
					$photo['user'] = $photo['photographer'];
					$meta = new MetadataInformations;
					$meta->filename = $filename;
					$meta->full_path = '/' . Settings::get('pexels_upload_folder') .'/' .$meta->filename;
					$meta->raw_data = $photo;
					$meta->author = $photo['photographer'];
					$meta->provider = 'pexels';
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
		
		$data = Http::get(self::PEXELS_API_ENDPOINT . '/curated/?per_page=' . Settings::get('pexels_per_page') , function($http){
			$http->header('Authorization', Settings::get('pexels_api_key'));
		});		
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		$returnData = $photoData;
		$returnData['results'] = $photoData['photos'];
		//unset($returnData['photos']);
		return $returnData['photos'];
	}

	public function updateLimits($headers) {
		if(array_key_exists('X-Ratelimit-Limit',$headers)) {
			$settings = Settings::instance();
			$settings->pexels_limit = $headers['X-Ratelimit-Limit'];
			$settings->pexels_remain = $headers['X-Ratelimit-Remaining'];
			$settings->pexels_limit_reset = $headers['X-Ratelimit-Reset'];
			$settings->save();
		}
	}

	public function getLimit() {
		return Settings::get('pexels_limit');
	}

	public function getRemainig() {
		return Settings::get('pexels_remain');
	}
}