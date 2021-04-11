<?php

return [
	'providers' => 'Stock photos',
	'no_items_to_show' => 'No pictures available for this provider',
	'no_items_for_this_provider' => 'Sorry, but this provider probably not working. Please, check your limit rates or remaining API calls.',
	'how_it_works' => 'How this works?',
	'how_this_works' => 'On first loading of media library we will load most recent pictures from selected provider.',
	'available_sources' => 'Image sources available for this provider.',
	'titles' => [
		'random_photos' => 'Random photos from current provider'
	],

	// filters
	'filters' => [
		'size_filter' => 'Image size (megapixels)',
		'sizes' => [
			'all' => 'Not important',
			'large' => '24MP',
			'medium' => '12MP',
			'small' => '4MP'
		],
		'orientation_filter' => 'Filter by orientation',		
		'orientation' => [
			'all' => 'Not important',
			'vertical' => 'Vertical',
			'horizontal' => 'Horizontal',
			'square' => 'Square',
			'portrait' => 'Portrait',
			'landscape' => 'Landscape'
		],
		'image_type' => 'Image type',
		'image_types' => [
			'photo' => 'Photo',
			'illustration' => 'Illustration',
			'vector' => 'Vector',
			'all' => 'Not importan'
		],
		'content_safety' => 'Safe content only',
		'colors' => [
			'black_and_white' => 'black and white', 
			'black' => 'black', 
			'white' => 'white', 
			'yellow' => 'yellow', 
			'orange' => 'orange', 
			'red' => 'red', 
			'purple' => 'purple', 
			'magenta' => 'magenta', 
			'green' => 'green', 
			'teal' => 'teal', 
			'blue' => 'blue'
		]
	]
];