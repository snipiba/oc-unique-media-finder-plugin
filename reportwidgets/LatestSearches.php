<?php
namespace SNiPI\UniqueMediaFinder\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use SNiPI\UniqueMediaFinder\Models\Search;

class LatestSearches extends ReportWidgetBase
{

	public function defineProperties()
	{
	    return [
	        'title' => [
	            'title'             => 'Widget title',
	            'default'           => 'Latest search',
	            'type'              => 'string',
	            'validationPattern' => '^.+$',
	            'validationMessage' => 'The Widget Title is required.'
	        ],
	        'searches' => [
	            'title'             => 'Number of searches to display data for',
	            'default'           => '3',
	            'type'              => 'string',
	            'validationPattern' => '^[0-9]+$'
	        ]
	    ];
	}

    public function render()
    {

    	$searches = Search::selectRaw('count(*) as count, created_at,provider, search_query, search_parameters')
    		->groupBy(['provider','search_query'])
    		->orderBy('count','desc')
    		->orderBy('created_at','desc')
    		->limit($this->property('searches'))->get();

        return $this->makePartial('widget', ['data' => $searches]);
    }
}