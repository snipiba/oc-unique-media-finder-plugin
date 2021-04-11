<?php

return [
	'name' => 'Pixabay',
	'url' => 'https://www.pixabay.com',
	'claim' => 'Stunning free images & royalty free stock',
	'about' => 'Over 2.2 million+ high quality stock images, videos and music shared by our talented community.',
	'apidoc' => 'https://pixabay.com/api/docs/',
	'how_it_works' => 'Searching on pixabay stock database is performed thru API endpoints. First call on API endpoint will check, if API was operational and active, otherwise is provider disabled for usage.',
	'data_information' => 'Due of minimum information provided by current provider (Pixabay), we are unable to show you more informations for this picture.<br/>Please, check usage instructions on Piaxabay site.',
	'api_usage_information' => 'This search results was provided by Pixabay.com API endpoints.',
	'available_for_full_api_access' => 'Options available for FULL API access',
	'provider_note' => 'Showing search results from PIXABAY stock photo databank.',
	'introduction' => [
		'pixabay_title' => 'Configure API settings for PIXABAY',
		'pixabay_about' => '<a href="https://www.pixabay.com/about/" target="_blank">PEXELS</a> is a free photo gallery that provides royalty free stock photos.',
		'pixabay_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://www.pixabay.com/api/" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.'
	],
	'settings' => [
		'pixabay_api_key' => 'API key',
		'pixabay_api_key_comment' => 'Enter API key obtained in PEXELS page',
		'pixabay_per_page' => 'Limit results per page',
		'pixabay_upload_folder' => 'Directory to download',
		'pixabay_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
		'pixbay_limit' => 'Pixbay LIMIT rate',
		'pixbay_remain' => 'Pixbay remaining',
		'pixabay_download_size' => 'Preffered download size',
		'pixabay_download_size_comment' => 'Pick preffered download size on primary download button.',
		'original' => 'Original',
		'fullhd' => 'Full HD',
		'large_image' => 'Large',		
		'webformat' => 'Medium',
		'small' => 'Preview',
		'pixabay_full_access_api' => 'Active FULL API Access?',
		'pixabay_full_access_api_comment' => 'Check this, if you have activated FULL api access. This will allow you to download original file and other formats.'
	],
	'forms' => [

	],
	'errors' => [

	]
];