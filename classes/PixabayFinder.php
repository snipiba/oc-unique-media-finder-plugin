<?php

namespace SNiPI\UniqueMediaFinder\Classes;

use SNiPI\UniqueMediaFinder\Models\Settings;
use SNiPI\UniqueMediaFinder\Models\MetadataInformations;
use BackendAuth;
use Storage;
use Session;
use FlashMessage;
use Http;

class PixabayFinder implements FinderInterface {
	

	const PIXABAY_API_ENDPOINT = 'https://pixabay.com/api';

	public function __construct() {
		if(empty(Settings::get('pixabay_api_key'))) {			
			return;
		} 
	}

	public function configured():bool {
		return empty(Settings::get('pixabay_api_key')) ? false : true;
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
		$per_page = Settings::get('pixabay_per_page') ?? 10;
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
		$imageType = '';
		if(array_key_exists('image_type', $options) && $options['image_type'] != 'all') {
			$imageType = '&image_type=' . $options['image_type'];
		}
		$data = Http::get(self::PIXABAY_API_ENDPOINT . '/?page=' . $page . $orientation . $imageType . $size .'&q=' . urlencode($query) .'&per_page=' . $per_page.'&key='.Settings::get('pixabay_api_key'));
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		$photoData['results'] = $photoData['hits'];

		unset($photoData['hits']);

		return $photoData;
	}

	/**
	 * @param string $photoIdentifier unique ID of photo
	 *
	 * @return PhotoInterface
	 */ 
	public function getPhoto(string $photoIdentifier): array
	{
		$per_page = Settings::get('pixabay_per_page') ?? 10;
		$return = '';
		$data = Http::get(self::PIXABAY_API_ENDPOINT . '/?id=' . $photoIdentifier.'&key='.Settings::get('pixabay_api_key'));
		$this->updateLimits($data->headers);
		$photoData = json_decode($data->body, true);
		if(count($photoData['hits'])==1){
			$return = $photoData['hits'][0];
		}
		return $return;
	}

	public function downloadPhoto(string $photoIdentifier): bool
	{
		$data = Http::get(self::PIXABAY_API_ENDPOINT . '/?id=' . $photoIdentifier . '&key=' . Settings::get('pixabay_api_key'));
		$this->updateLimits($data->headers);
		$photo = json_decode($data->body, true);
		if($photo) {

			$photoData = $photo['hits'][0];
			$pathToDownload = $photoData[Settings::get('pixabay_download_size') .'URL'];
			
			$rawData = Http::get($pathToDownload);
			$pi = pathinfo($pathToDownload);
			if(!Storage::exists('media/' . Settings::get('pixabay_upload_folder'))) {
				Storage::makeDirectory('media/' . Settings::get('pixabay_upload_folder'));
			}
			$file =Storage::put('media/' . Settings::get('pixabay_upload_folder') .'/pixabay_' . $photoIdentifier.'.' . $pi['extension'],
				$rawData->body
			);
			if($file) {				
				if(Settings::get('store_metadata')) {
					$photoData['width'] = $photoData['imageWidth'];
					$photoData['height'] = $photoData['imageHeight'];
					$meta = new MetadataInformations;
					$meta->filename = 'pixabay_' . $photoIdentifier . '.' . $pi['extension'];
					$meta->raw_data = $photoData;
					$meta->author = $photoData['user'];
					$meta->provider = 'pixabay';
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
		return [];
	}

	public function updateLimits($headers) {
		if(array_key_exists('x-ratelimit-limit',$headers)) {
			$settings = Settings::instance();
			$settings->pixabay_limit = $headers['x-ratelimit-limit'];
			$settings->pixabay_remain = $headers['x-ratelimit-remaining'];
			$settings->pixabay_limit_reset = $headers['x-ratelimit-reset'];
			$settings->save();
		}
	}


	public function getLimit() {
		return Settings::get('pixabay_limit');
	}

	public function getRemainig() {
		return Settings::get('pixabay_remain');
	}	

}