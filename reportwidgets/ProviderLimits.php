<?php
namespace SNiPI\UniqueMediaFinder\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use SNiPI\UniqueMediaFinder\Classes\UniqueMediaFinder;

class ProviderLimits extends ReportWidgetBase {


    public function render()
    {

    	$this->vars['providers'] = UniqueMediaFinder::getProviders();
    	
        return $this->makePartial('widget');
    }	
    
}