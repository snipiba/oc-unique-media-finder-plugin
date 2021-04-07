<?php 
namespace SNiPI\UniqueMediaFinder;

use Backend;
use Config;
use System\Classes\PluginBase;
use SNiPI\UniqueMediaFinder\Models\Settings;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
            'description' => 'snipi.uniquemediafinder::lang.plugin.plugin_desc',
            'author'      => 'SNiPI',
            'icon'        => 'icon-camera',
            'homepage'    => 'https://github.com/snipiba/oc-unique-media-finder-plugin'
        ];
    }


    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
                'icon'        => 'icon-bar-chart-o',
                'description' => 'snipi.uniquemediafinder::lang.plugin.plugin_desc_settings',
                'class'       => 'SNiPI\UniqueMediaFinder\Models\Settings',
                'order'       => 400
            ]
        ];
    }

    public function boot()
    {


        \Backend\Widgets\MediaManager::extend(function ($widget) {
            $widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/backend/widgets/mediamanager/partials/');
            $widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/partials/');
            $widget->addJs('/plugins/snipi/uniquemediafinder/assets/js/uniquefinder.js');
            $widget->addCss('/plugins/snipi/uniquemediafinder/assets/css/custom.css');

            $widget->addDynamicMethod('onDownloadPhoto', function() use ($widget){

                $widget->vars['path'] = \Input::get('path');
                $widget->vars['file_id'] = \Input::get('fileId');
                $file = new \System\Models\File;
                $file->fromUrl(\Input::get('path'), \Input::get('qs') . '_' . \Input::get('fileId').'.jpg');
                $savedFile = $file->save();
                $filename = $file->getLocalPath();
                try {
                    if(!\Storage::exists('media/' . \Input::get('folder'))) {
                        \Storage::makeDirectory('media/' . \Input::get('folder'));
                    }
                    \Storage::copy(str_replace('/app','',str_replace('\app','',str_replace(storage_path(),'',$file->getLocalPath()))) , 'media/' . \Input::get('folder') . '/' . basename($filename));
                    sleep(2);
                    $file->delete();
                } catch(Exception $e) {

                }
            });

            $widget->addDynamicMethod('onShowPhoto', function() use ($widget){

                $widget->vars['path'] = \Input::get('path');
                return $widget->makePartial('photo');
            });

            $widget->addDynamicMethod('onUniqueMediaSearch', function() use ($widget) {

                //Set the media path
                $base = Backend::url('backend/media');
                $path = base_path() . Config::get('cms.storage.media.path');

                //Get the images & editing values
                $query = post('query');
                
                /*tracelog($checked);*/
                if(empty($query)) {
                   throw new \Exception(trans('snipi.uniquemediafinder::lang.errors.no_search_query')); 
                }
                
                if(false === empty(Settings::get('unsplash_api_key'))) {
                    $response['unsplash'] = true;
                    \Unsplash\HttpClient::init([
                        'applicationId' => Settings::get('unsplash_api_key'),
                        'utmSource' => Settings::get('unsplash_application_name'),
                    ]);

                    $photos = \Unsplash\Search::photos($query, post('page') ?? 1, Settings::get('unsplash_per_page') ?? 20, null);
                    
                    $response['unsplash'] = [
                        'results' => ($photos->getTotal() > 0) ? true : false,
                        'total' => $photos->getTotal(),
                        'pages' => $photos->getTotalPages(),
                        'photos' => $photos->getResults()
                    ];
                    
                    
                }
                if(false === empty(Settings::get('pexels_api_key'))) {
                    $response['pexels'] = true;

                    $client = \Http::get('https://api.pexels.com/v1/search?query=' . urlencode($query) . '&per_page=' . (Settings::get('pexels_per_page')??20), function($http){
                        $http->header('Authorization', Settings::get('pexels_api_key'));    
                    });
                    $body = json_decode($client->body);
                    $response['pexels'] = [
                        'results' => ($body->total_results > 0) ? true : false,
                        'total' => $body->total_results,
                        'photos' => $body->photos
                    ];

                }
                $widget->vars['unsplash'] = $response['unsplash'];
                $widget->vars['pexels'] = $response['pexels'];
                $widget->vars['search'] = $query;
                return [
                    '#mediaResults' => $widget->makePartial('mediaresults', ['unsplash' => $response['unsplash'], 'pexels' => $response['pexels']])
                ];
            });            


        });        
        set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/vendor/unsplash/unsplash/src');
        
    }
}