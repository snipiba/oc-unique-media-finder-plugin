<?php

	return [
		'plugin' => [
			'plugin_name' => 'Unique media finder',
			'plugin_description' => 'Media finder extension for searching images on most free to use stock galleries like Unsplash and Pexels.',
			'plugin_desc_settings' => 'Search stock galleries in ease.'
		],
		'introduction' => [
			'title' => 'Unique media finder configuration',
			'about' => 'This plugin allows users to search media files on various databases like Unsplash or Pexels.<br/>For search is used open API, then you need to setup some API keys to use API endpoints to search and download photos to your media library database stored in your local server.',
			'title_support' => 'Support my work',
			'support' => 'If you wish, you can provide some donation for my work on this plugin or on other plugins for OctoberCMS. For more info see my website <a href="https://www.snipi.sk?ref=uniquemediafinder" target="_blank">SNiPI.sk</a>.',
			'unsplash_title' => 'Configure API settings for UNSPLASH',
			'unsplash_about' => '<a href="https://unsplash.com/about" target="_blank">UNSPLASH</a> is an open source royalty free stock database where is over 2 milions photographies and high-resolution images, which is free to use.',
			'unsplash_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://unsplash.com/oauth/applications/new" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.',
			'pexels_title' => 'Configure API settings for PEXELS',
			'pexels_about' => '<a href="https://www.pexels.com/about/" target="_blank">PEXELS</a> is a free photo gallery that provides royalty free stock photos.',
			'pexels_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://www.pexels.com/api/" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.',
			'pixabay_title' => 'Configure API settings for PIXABAY',
			'pixabay_about' => '<a href="https://www.pixabay.com/about/" target="_blank">PEXELS</a> is a free photo gallery that provides royalty free stock photos.',
			'pixabay_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://www.pixabay.com/api/" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.'
		],
		'settings' => [
			'tab_unsplash' => 'Unsplash API',
			'unsplash_api_key' => 'API key',
			'unsplash_api_key_comment' => 'Enter API key obtained in UNSPLASH page',
			'unsplash_application_name' => 'Application name',
			'unsplash_application_name_comment' => 'Name of your application created on unsplash.com page',
			'unsplash_per_page' => 'Limit results per page',
			'unsplash_upload_folder' => 'Directory to download',
			'unsplash_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
			'tab_pexels' => 'Pexels API',
			'pexels_api_key' => 'API key',
			'pexels_api_key_comment' => 'Enter API key obtained in PEXELS page',
			'pexels_per_page' => 'Limit results per page',
			'pexels_upload_folder' => 'Directory to download',
			'pexels_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
			'tab_pixabay' => 'Pixabay API',
			'pixabay_api_key' => 'API key',
			'pixabay_api_key_comment' => 'Enter API key obtained in PEXELS page',
			'pixabay_per_page' => 'Limit results per page',
			'pixabay_upload_folder' => 'Directory to download',
			'pixabay_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
		],
		'forms' => [
			'search_for_photo_hint' => 'This keywords will be used for search on all configured api endpoints.',
			'search_for_photo' => 'Search for',
			'search_photos' => 'Search now',
			'search_for_photo_modal_title' => 'Searching',
			'enter_keyword_hit_enter' => 'type keyword and hit enter to perform search'
 		],
		'errors' => [
			'no_search_query' => 'Please, provide correct search query. Empty string is not allowed.'
		],
		'results' => [
			'found' => '{1}One picture found for |{2,Inf}Found :count pictures for'
		],
		'buttons' => [
			'look' => 'View photo',
			'download' => 'Download to library'
		],
		'flash' => [
			'pic_downloaded' => 'Picture was successfully downloaded to folder ',
			'pic_error' => 'Unable to download picture.'
		],
		'photo' => [
			'downloads' => 'Downloads',
			'download_photo' => 'Download this photo',
			'views' => 'Views',
			'updated' => 'Updated',
			'exif_information' => 'Exif information',
			'dimensions' => 'Dimensions',
			'size' => 'Filesize',
			'description' => 'Description',
			'support_author' => 'Support photographer',
			'no_description_provided' => 'Photographer not provided any description.',
			'support_author_title' => 'Support this author if you can',
			'support_author_text' => 'All photos provided on Unsplash are royalty free and can be used without any purchase and without any notation of author. Me - as author of this plugin and as a photographer - can tell, that any small line of text, where is noted author, is helpfull. Really, be kind and use html code below, to show small information about photographer, to support his/her work.',
			'provided_by' => 'This photography is provided by',
			'royalty_free' => ' ~ royalty free photo stock bank.',
			'provider_unsplash' => 'Unsplash.com',
			'provider_pexels' => 'Pexels.com',
			'provider_pixabay' => 'Pixabay.com'
		],
		'exif' => [
			'make' => 'Camera manufacturer',
			'model' => 'Camera model',
			'exposure_time' => 'Exposure time',
			'aperture' => 'Aperture',
			'focal_length' => 'Focal length',
			'iso' => 'ISO'
		]
	];
