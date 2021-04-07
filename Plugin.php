<?php 
namespace SNiPI\UniqueMediaFinder;

use Backend;
use Config;
use Input;
use Storage;
use Http;
use System\Classes\PluginBase;
use Backend\Widgets\MediaManager;
use SNiPI\UniqueMediaFinder\Models\Settings;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'snipi.uniquemediafinder::lang.plugin.plugin_name',
            'description' => 'snipi.uniquemediafinder::lang.plugin.plugin_desc',
            'author'      => 'SNiPI',
            'icon'        => 'icon-picture-o',
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

    public function boot()
    {

        MediaManager::extend(function ($widget) {
            $widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/backend/widgets/mediamanager/partials/');
            $widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/partials/');
            $widget->addJs('/plugins/snipi/uniquemediafinder/assets/js/uniquefinder.js');
            $widget->addCss('/plugins/snipi/uniquemediafinder/assets/css/custom.css');

            $widget->addDynamicMethod('onDownloadPhoto', function() use ($widget){

                $widget->vars['path'] = Input::get('path');
                $widget->vars['file_id'] = Input::get('fileId');
                $file = new \System\Models\File;
                $file->fromUrl(Input::get('path'), Input::get('qs') . '_' . Input::get('fileId').'.jpg');
                $savedFile = $file->save();
                $filename = $file->getLocalPath();
                try {
                    if(!Storage::exists('media/' . Input::get('folder'))) {
                        Storage::makeDirectory('media/' . Input::get('folder'));
                    }
                    Storage::copy(str_replace('/app','',str_replace('\app','',str_replace(storage_path(),'',$file->getLocalPath()))) , 'media/' . Input::get('folder') . '/' . basename($filename));
                    sleep(2);
                    $file->delete();
                } catch(Exception $e) {

                }
            });

            $widget->addDynamicMethod('onShowPhoto', function() use ($widget){
                $type = Input::get('type');
                $id = Input::get('id');
                Switch($type) {

                    case 'unsplash':
                        \Unsplash\HttpClient::init([
                            'applicationId' => Settings::get('unsplash_api_key'),
                            'utmSource' => Settings::get('unsplash_application_name'),
                        ]);
                        $photo = \Unsplash\Photo::find($id)->toArray();
                    break;

                    case 'pexels':
                    $client = Http::get('https://api.pexels.com/v1/photos/' . $id, function($http){
                        $http->header('Authorization', Settings::get('pexels_api_key'));    
                    });
                    $photo = json_decode($client->body,true);
                    break;
                }
                $widget->vars['photo'] = $photo;
                $widget->vars['type'] = $type;
                $widget->vars['search'] = Input::get('search');
                $widget->vars['path'] = Input::get('path');
                return $widget->makePartial('photo');
            });

            $widget->addDynamicMethod('onPaginate', function() use ($widget){

                $widget->vars['search'] = $query = Input::get('query');
                $widget->vars['page'] = Input::get('page');
                $widget->vars['provider'] = Input::get('provider');

                if(empty($query)) {
                   throw new \Exception(trans('snipi.uniquemediafinder::lang.errors.no_search_query')); 
                }
                
                if(false === empty(Settings::get('unsplash_api_key'))) {
                    $response['unsplash'] = true;
                    \Unsplash\HttpClient::init([
                        'applicationId' => Settings::get('unsplash_api_key'),
                        'utmSource' => Settings::get('unsplash_application_name'),
                    ]);
                    
                    try {    
                        $photos = \Unsplash\Search::photos($query, post('page') ?? 1, Settings::get('unsplash_per_page') ?? 20, null);
                        
                        $response['unsplash'] = [
                            'results' => ($photos->getTotal() > 0) ? true : false,
                            'total' => $photos->getTotal(),
                            'pages' => $photos->getTotalPages(),
                            'photos' => $photos->getResults(),
                            'page' => post('page')
                        ];
                    } catch(\Exception $e) {
                        $response['unsplash'] = [
                            'results' => false,
                            'error' => $e->getMessage()
                        ];
                    }
                    
                    
                }
                if(false === empty(Settings::get('pexels_api_key'))) {
                    $response['pexels'] = true;

                    $client = Http::get('https://api.pexels.com/v1/search?query=' . urlencode($query) . '&page='.Input::get('page').'&per_page=' . (Settings::get('pexels_per_page')??20), function($http){
                        $http->header('Authorization', Settings::get('pexels_api_key'));    
                    });
                    $body = json_decode($client->body);
                    $response['pexels'] = [
                        'results' => ($body->total_results > 0) ? true : false,
                        'total' => $body->total_results,
                        'photos' => $body->photos,
                        'page' => post('page')
                    ];

                }
                $widget->vars['unsplash'] = $response['unsplash'];
                $widget->vars['pexels'] = $response['pexels'];
                $widget->vars['search'] = $query;
                return [
                    '#' . Input::get('provider').'-list' => $widget->makePartial(Input::get('provider').'-list', ['unsplash' => $response['unsplash'], 'pexels' => $response['pexels']])
                ];
            });

            $widget->addDynamicMethod('onUniqueMediaSearch', function() use ($widget) {

                //Get the images & editing values
                $query = post('query');
                
                $widget->vars['provider'] = 'unsplash';
                $widget->vars['page'] = 1;
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

                    try {
                        $photos = \Unsplash\Search::photos($query, post('page') ?? 1, Settings::get('unsplash_per_page') ?? 20, null);
                        $response['unsplash'] = [
                            'results' => ($photos->getTotal() > 0) ? true : false,
                            'total' => $photos->getTotal(),
                            'pages' => $photos->getTotalPages(),
                            'photos' => $photos->getResults()
                        ];   
                    } catch(\Exception $e) {
                        $response['unsplash'] = [
                            'results' => false,
                            'error' => $e->getMessage()
                        ];
                    }
                    
                }
                if(false === empty(Settings::get('pexels_api_key'))) {
                    $response['pexels'] = true;

                    $client = Http::get('https://api.pexels.com/v1/search?query=' . urlencode($query) . '&per_page=' . (Settings::get('pexels_per_page')??20), function($http){
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