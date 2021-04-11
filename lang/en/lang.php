<?php

	return [
		'plugin' => [
			'plugin_name' => 'Unique media finder',
			'plugin_description' => 'Media finder extension for searching images on most free to use stock galleries like Unsplash and Pexels.',
			'plugin_desc' => 'Media finder extension for searching images on most free to use stock galleries like Unsplash and Pexels.',
			'plugin_desc_settings' => 'Search stock galleries in ease.'
		],
		'component' => [
			'file_path' => 'File path',
			'file_path_description' => 'Path to file in media library',
			'source_label' => 'Label',
			'source_label_description' => 'Label before author and source',
			'source_join' => 'Joiner',
			'source_join_description' => 'Join string between author and provider',
			'show_author' => 'Show author',
			'show_author_description' => 'Show name of author',
			'show_provider' => 'Show source',
			'show_provider_description' => 'Show provider source',
			'nostyle' => 'Without styles',
			'nostyle_description' => 'Dont use css styles',
			'cssClasses' => 'CSS classes',
			'cssClasses_description' => 'Use css classes for container',
			'name' => 'Media file',
			'description' => 'Showing media with stored metadata.'
		],
		'introduction' => [
			'title' => 'Unique media finder configuration',
			'about' => 'This plugin allows users to search media files on various databases like Unsplash or Pexels.<br/>For search is used open API, then you need to setup some API keys to use API endpoints to search and download photos to your media library database stored in your local server.',
			'title_support' => 'Support my work',
			'support' => 'If you wish, you can provide some donation for my work on this plugin or on other plugins for OctoberCMS. For more info see my website <a href="https://www.snipi.sk?ref=uniquemediafinder" target="_blank">SNiPI.sk</a>.',			

			'notifications_title' => 'Notification about reaching low limits on api endpoints.',
			'notifications_about' => 'Each API endpoint has a different limitations and remaining free api requests. Get notification each time, when api rate goes low, and can probably disallow you from using search on some provider.'
		],
		'settings' => [
			'tab_unsplash' => 'Unsplash API',
			'tab_pexels' => 'Pexels API',
			'tab_notifications' => 'Notifications',
			'tab_database' => 'Storage informations',
			'tab_processing' => 'Processing images',
			'tab_pixabay' => 'Pixabay API',
			'notify_low_rates' => 'Notify by e-mail when remaining counts are low',
			'notify_email' => 'Email address to notify',
			'notify_template' => 'Template to send',
			'allow_postprocessing' => 'Enable image postprocessing',
			'allow_postprocessing_comment' => 'When is enabled, you can configure how will be images processed after download.',
			'use_database' => 'Use database storage',
			'use_database_comment' => 'Use database storage for caching requests and responses',
			'store_errors' => 'Log API errors',
			'store_errors_comment' => 'Will you store all API errors, when you dont get any response?',
			'store_search' => 'Store each search query',
			'store_search_comment' => 'Store search queries, for create statistics of most used keywords',
			'store_metadata' => 'Store metadata',
			'store_metadata_comment' => 'Store all data for downloaded pictures, to allow media library load extended information about image'
		],
		'forms' => [
			'search_for_photo_hint' => 'This keywords will be used for search on all configured api endpoints.',
			'search_for_photo' => 'Search for',
			'search_photos' => 'Search now',
			'search_for_photo_modal_title' => 'Searching',
			'enter_keyword_hit_enter' => 'type keyword and hit enter to perform search'
 		],
		'errors' => [
			'no_search_query' => 'Please, provide correct search query. Empty string is not allowed.',
			'configuration_warning' => 'Configuration needed',
			'configuration_needs_attention' => 'Please, check errors bottom, to get this plugin work properly',
			'configuration_provider_unsplash' => 'Unsplash provider is not configured. Please, provide API key (access key) otherwise this provider was not activated.',
			'configuration_provider_pexels' => 'Pexels provider is not configured. Please, provide API key (access key) otherwise this provider was not activated.',
			'configuration_provider_pixabay' => 'Pixabay provider is not configured. Please, provide API key (access key) otherwise this provider was not activated.'
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
			'pic_error' => 'Unable to download picture.',
			'open_download_folder' => 'Will you open folder with downloaded picture?'
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
		],
		'callouts' => [
			'remaining_traffic' => 'Information about traffic and limits',
			'traffic_status' => 'Did u know, how many request you can make?',
			'remaining' => '{0}No remaining traffic left for this provider (:remains/:limit):limit.|{1}Last remaining request for this provider (:remains/:limit)|{2,Inf}:remains remaining request from :limit for this provider.'
		],
		'searching_for' => 'Searching for',
		'processing' => [
			'heading' => 'Post processing images after downloading',
			'enabling_post_processing' => 'Because many of downloaded pictures are really large, then you will probably make some optimalization after downloading images. Here you can manage what to do, with any of downloaded picture and how this processing will be executed.',
			'optimalization' => 'Optimalization can be achieved with resizing images, lowering image quality or converting to webp format. Please, be patient with optimalization, because <strong>this feature is still in progress</strong>.'
		],
		'status' => [
			'all_ok' => 'Operational OK',
			'warning_bellow_10' => 'Warning! Limit is below 10',
			'warning_bellow_20' => 'Warnint! Limit is below 20',
			'not_operational' => 'Not operational. Need wait to reset per hours or months.'
		],
		'database' => [
			'heading' => 'Storing photo and provider informations',
			'enable_storing' => 'When you enable storing informations from providers about photos and images, you can use it withou any aditional searching for informations.',
			'how_it_works' => 'When picture was downloaded, this feature will save each information from provider, to allow you in future to use this informations, for ex. sourcing author, etc. When this feature is enabled, this plugin will load aditional informations for picture in medialibrary details panel.'
		],
		'metadata' => 'Unique metadata',
		'exif_informations' => 'Exif informations for file',
		'no_metadata_stored_for_file' => 'This file are not downloaded thru unique media finder plugin, then no metadata was stored.',
		'will_add_some_metadata' => 'If you will to add some metadata for this file, you can install <strong>MediaMetadata</strong> plugin from SNiPI.'
	];
