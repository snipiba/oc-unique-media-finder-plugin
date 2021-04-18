<?php 
namespace SNiPI\UniqueMediaFinder;

use Backend;
use Config;
use Input;
use Http;
use Session;
use Illuminate\Filesystem\Filesystem;
use Backend\Widgets\MediaManager;
use System\Classes\PluginBase;
use SNiPI\UniqueMediaFinder\Models\Settings;
use SNiPI\UniqueMediaFinder\Models\MetadataInformations;
use SNiPI\UniqueMediaFinder\Classes\UnsplashFinder;
use SNiPI\UniqueMediaFinder\Classes\PexelsFinder;
use SNiPI\UniqueMediaFinder\Classes\PixabayFinder;
use SNiPI\UniqueMediaFinder\Classes\UniqueMediaFinder;

class Plugin extends PluginBase
{

    protected const PROVIDERS = ['unsplash', 'pexels', 'pixabay'];
    protected $providers;

    public $require = ['RainLab.Translate'];


    public function pluginDetails()
    {
        return [
            'name'        => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
            'description' => 'snipi.uniquemediafinder::lang.plugin.plugin_desc',
            'author'      => 'SNiPI',
            'icon'        => 'icon-picture-o',
            'iconSvg'     => 'plugins/snipi/uniquemdiafinder/assets/img/search.svg',
            'homepage'    => 'https://github.com/snipiba/oc-unique-media-finder-plugin'
        ];
    }


    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
                'icon'        => 'icon-picture-o',
                'category'    => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
                'description' => 'snipi.uniquemediafinder::lang.plugin.plugin_desc_settings',
                'class'       => 'SNiPI\UniqueMediaFinder\Models\Settings',
                'order'       => 400
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'snipi.uniquemediafinder::mail.low_limit_reached' => 'Notification when API rates are low.',
            'snipi.uniquemediafinder::mail.send_photo_by_mail'  => 'Send photo by e-mail.'
        ];
    }

    public function registerMailLayouts()
    {
        return [
            'notification' => 'snipi.uniquemediafinder::mail.layouts.notification',
        ];
    }

    public function boot() {
        $this->providers['unsplash'] = new UnsplashFinder;
        $this->providers['pexels'] = new PexelsFinder;
        $this->providers['pixabay'] = new PixabayFinder;

        $mediaFinder = new UniqueMediaFinder($this->providers);
        $mediaFinder->extendMediaManager();

        
    }

    public function registerPageSnippets() {
        return [
            'SNiPI\UniqueMediaFinder\Components\MediaInfo' => 'mediainfo'
        ];
    }

    public function registerComponents() {
        return [
            'SNiPI\UniqueMediaFinder\Components\MediaInfo' => 'mediainfo'
        ];   
    }
    
    public function registerReportWidgets()
    {
        return [
            'SNiPI\UniqueMediaFinder\ReportWidgets\LatestSearches' => [
                'label'   => 'Show latest searches',
                'context' => 'dashboard',
            ],
            'SNiPI\UniqueMediaFinder\ReportWidgets\ProviderLimits' => [
                'label'   => 'Show limits of providers',
                'context' => 'dashboard',
            ]
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'mediainfo' => [$this, 'getMediaInfo'],
            ]
        ];
    }

    public function getMediaInfo($value) {
        $data = MetadataInformations::where('filename', basename($value))->first();
        if($data) {
            return $data;
        }        
    }

}