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
		'unsplash_title' => 'Configure API settings for UNSPLASH',
		'unsplash_about' => '<a href="https://unsplash.com/about" target="_blank">UNSPLASH</a> is an open source royalty free stock database where is over 2 milions photographies and high-resolution images, which is free to use.',
		'unsplash_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://unsplash.com/oauth/applications/new" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.',
	],
	'settings' => [
		'unsplash_api_key' => 'API key',
		'unsplash_api_key_comment' => 'Enter API key obtained in UNSPLASH page',
		'unsplash_application_name' => 'Application name',
		'unsplash_application_name_comment' => 'Name of your application created on unsplash.com page',
		'unsplash_per_page' => 'Limit results per page',
		'unsplash_upload_folder' => 'Directory to download',
		'unsplash_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
		'unsplash_limit' => 'Unsplash LIMIT rate',
		'unsplash_remain' => 'Unsplash remaining',
		'enable_unsplash' => 'Enable this provider',
		'enable_unsplash_comment' => 'Enable if you wish search with this provider.',
		'unsplash_default_download_quality' => 'Default download quality',
        'raw' => 'Raw',
        'full' => 'Full',
        'regular' => 'Regular',
        'medium' => 'Medium',
        'small' => 'Small',
        'thumb' => 'Thumb',
	],
	'forms' => [

	],
	'errors' => [

	]
];