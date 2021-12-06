<?php

return [
	'name' => 'Unsplash',
	'url' => 'https://www.unsplash.com',
	'claim' => 'The internet’s source of freely-usable images.',
	'about' => 'Founded in 2013 as a humble Tumblr blog, Unsplash has grown into an industry-leading visual community. It’s become a source of inspiration for everyone from award-winning writers like Deepak Chopra to industry-titans like Apple, and millions of creators worldwide.',
	'apidoc' => 'https://unsplash.com/documentation',
	'how_it_works' => 'Searching on unsplash stock database is performed thru API endpoints. First call on API endpoint will check, if API was operational and active, otherwise is provider disabled for usage.',
	'api_usage_information' => 'This search results was provided by Unsplash.com API endpoints.',
	'introduction' => [
		'pexels_title' => 'Configure API settings for PEXELS',
		'pexels_about' => '<a href="https://www.pexels.com/about/" target="_blank">PEXELS</a> is a free photo gallery that provides royalty free stock photos.',
		'pexels_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://www.pexels.com/api/" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.',	
	],
	'settings' => [
		'pexels_api_key' => 'API key',
		'pexels_api_key_comment' => 'Enter API key obtained in PEXELS page',
		'pexels_per_page' => 'Limit results per page',
		'pexels_upload_folder' => 'Directory to download',
		'pexels_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
		'pexels_limit' => 'Pexels LIMIT rate',
		'pexels_remain' => 'Pexels remainig',
		'enable_pexels' => 'Enable this provider',
		'enable_pexels_comment' => 'Enable if you wish search with this provider.',
		'pexels_default_download_quality' => 'Default image quality for download',
		'original' => 'Original',
		'large2x' => 'Large 2x',
		'large' => 'Large',
		'medium' => 'Medium',
		'small' => 'Small',
		'portrait' => 'Portrait',
		'landscape' => 'Landscape',
		'tiny' => 'Tiny',
	],
	'forms' => [

	],
	'errors' => [

	]
];