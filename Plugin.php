<?php 
namespace SNiPI\UniqueMediaFinder;

use Backend;
use Config;
use Input;
use Storage;
use Http;
use \Unsplash;
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

                $provider = Input::get('provider');
                $path = Input::get('path');
                $fileId = Input::get('fileId');

                Switch($provider) {
                    case 'unsplash':
                        Unsplash\HttpClient::init([
                            'applicationId' => Settings::get('unsplash_api_key'),
                            'utmSource' => Settings::get('unsplash_application_name'),
                        ]);
                        $photo = Unsplash\Photo::find($fileId);
                        $path = $photo->download();                        
                    break;

                    case 'pexels':
                        $client = Http::get('https://api.pexels.com/v1/photos/' . $fileId, function($http){
                        $http->header('Authorization', Settings::get('pexels_api_key'));    
                    });
                    $photo = json_decode($client->body);
                    if($path !== $photo->src->original) {
                        $path = $photo->src->original;
                    }

                    break;
                }

                $widget->vars['path'] = $path;
                $widget->vars['file_id'] = $fileId;
                $file = new \System\Models\File;
                $newFileName = str_slug(Input::get('qs')) . '_' . $provider.'_' . Input::get('fileId').'.jpg';
                $file->fromUrl($path, $newFileName);
                $savedFile = $file->save();
                $filename = $file->getLocalPath();                
                try {
                    if(!Storage::exists('media/' . Input::get('folder'))) {
                        Storage::makeDirectory('media/' . Input::get('folder'));
                    }
                    Storage::copy(str_replace('/app','',str_replace('\app','',str_replace(storage_path(),'',$file->getLocalPath()))) , 'media/' . Input::get('folder') . '/' . $newFileName);
                    sleep(1);
                    $file->delete();
                } catch(Exception $e) {

                }
            });

            $widget->addDynamicMethod('onShowPhoto', function() use ($widget){
                $type = Input::get('type');
                $id = Input::get('id');
                Switch($type) {

                    case 'unsplash':
                        Unsplash\HttpClient::init([
                            'applicationId' => Settings::get('unsplash_api_key'),
                            'utmSource' => Settings::get('unsplash_application_name'),
                        ]);
                        $photo = Unsplash\Photo::find($id)->toArray();
                    break;

                    case 'pexels':
                    $client = Http::get('https://api.pexels.com/v1/photos/' . $id, function($http){
                        $http->header('Authorization', Settings::get('pexels_api_key'));    
                    });
                    $photo = json_decode($client->body,true);
                    break;

                    case 'pixabay':
                    $client = Http::get('https://pixabay.com/api?key='.Settings::get('pixabay_api_key').'&id=' . $id);
                    $photoData = json_decode($client->body,true);
                    $photo = $photoData['hits'][0];
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
                    Unsplash\HttpClient::init([
                        'applicationId' => Settings::get('unsplash_api_key'),
                        'utmSource' => Settings::get('unsplash_application_name'),
                    ]);
                    
                    try {    
                        $photos = Unsplash\Search::photos($query, post('page') ?? 1, Settings::get('unsplash_per_page') ?? 20, null);
                        
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

                if(false === empty(Settings::get('pixabay_api_key'))) {
                    $response['pixabay'] = true;

                    $client = Http::get('https://pixabay.com/api?key='.Settings::get('pixabay_api_key').'&q=' . urlencode($query) . '&image_type=photo&page='.Input::get('page').'&per_page=' . (Settings::get('pixabay_per_page')??20));
                    $body = json_decode($client->body);
                    $response['pixabay'] = [
                        'results' => ($body->totalHits > 0) ? true : false,
                        'total' => $body->totalHits,
                        'photos' => $body->hits,
                        'page' => post('page')
                    ];

                }
                $widget->vars['unsplash'] = $response['unsplash'];
                $widget->vars['pexels'] = $response['pexels'];
                $widget->vars['pixabay'] = $response['pixabay'];
                $widget->vars['search'] = $query;
                return [
                    '#' . Input::get('provider').'-list' => $widget->makePartial(Input::get('provider').'-list', ['unsplash' => $response['unsplash'], 'pexels' => $response['pexels'], 'pixabay' => $response['pixabay']])
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
                    Unsplash\HttpClient::init([
                        'applicationId' => Settings::get('unsplash_api_key'),
                        'utmSource' => Settings::get('unsplash_application_name'),
                    ]);

                    try {
                        $photos = Unsplash\Search::photos($query, post('page') ?? 1, Settings::get('unsplash_per_page') ?? 20, null);
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

                if(false === empty(Settings::get('pixabay_api_key'))) {
                    $response['pixabay'] = true;

                    $client = Http::get('https://pixabay.com/api?key='.Settings::get('pixabay_api_key').'&q=' . urlencode($query) . '&image_type=photo&per_page=' . (Settings::get('pixabay_per_page')??20));
                    $body = json_decode($client->body);
                    $response['pixabay'] = [
                        'results' => ($body->totalHits > 0) ? true : false,
                        'total' => $body->totalHits,
                        'photos' => $body->hits,
                        'page' => post('page')
                    ];

                }
                $widget->vars['unsplash'] = $response['unsplash'];
                $widget->vars['pexels'] = $response['pexels'];
                $widget->vars['pixabay'] = $response['pixabay'];
                $widget->vars['search'] = $query;
                return [
                    '#mediaResults' => $widget->makePartial('mediaresults', ['unsplash' => $response['unsplash'], 'pexels' => $response['pexels'], 'pixabay' => $response['pixabay']])
                ];
            });            


        });        
        set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/vendor/unsplash/unsplash/src');
        
    }
}