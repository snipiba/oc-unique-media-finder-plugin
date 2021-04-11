<?php
namespace SNiPI\UniqueMediaFinder\Components;

use Cms\Classes\ComponentBase;

class MediaInfo extends ComponentBase {
	
	public function componentDetails()
    {
        return [
            'name' => 'snipi.uniquemediafinder::lang.component.name',
            'description' => 'snipi.uniquemediafinder::lang.component.description'
        ];
    }

    public function defineProperties()
	{
	    return [
	        'file_path' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.file_path',
	             'description'       => 'snipi.uniquemediafinder::lang.component.file_path_description',
	             'type'              => 'string',
	             'required'			=> true,
	        ],
	        'source_label' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.source_label',
	             'description'       => 'snipi.uniquemediafinder::lang.component.source_label_description',
	             'default'			=> 'Photo source',
	             'type'              => 'string',
	        ],
	        'source_join' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.source_join',
	             'description'       => 'snipi.uniquemediafinder::lang.component.source_join_description',
	             'default'			=> 'via',
	             'type'              => 'string',
	        ],
	        'show_author' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.show_author',
	             'description'       => 'snipi.uniquemediafinder::lang.component.show_author_description',
	             'default'			=> 'via',
	             'type'              => 'checkbox',
	             'default'			=> 1
	        ],
	        'show_provider' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.show_provider',
	             'description'       => 'snipi.uniquemediafinder::lang.component.show_provider_description',
	             'default'			=> 'via',
	             'type'              => 'checkbox',
	             'default'			=> 1
	        ],
	        'nostyle' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.nostyle',
	             'description'       => 'snipi.uniquemediafinder::lang.component.nostyle_description',
	             'default'			=> 'via',
	             'type'              => 'checkbox',
	             'default'			=> 0
	        ],
	        'cssClasses' => [
	             'title'             => 'snipi.uniquemediafinder::lang.component.cssClasses',
	             'description'       => 'snipi.uniquemediafinder::lang.component.cssClasses_description',
	             'type'              => 'string',
	        ],

	    ];
	}
}