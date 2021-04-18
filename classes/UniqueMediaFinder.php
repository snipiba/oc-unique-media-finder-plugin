<?php
namespace SNiPI\UniqueMediaFinder\Classes;

use Illuminate\Filesystem\Filesystem;
use Storage;
use Input;
use Mail;
use Lang;
use BackendAuth;
use SNiPI\UniqueMediaFinder\Models\Search;
use SNiPI\UniqueMediaFinder\Models\MetadataInformations;
use SNiPI\UniqueMediaFinder\Models\Settings;

class UniqueMediaFinder {

	protected $providers;

	public function __construct($providers) {
		$this->providers = $providers;
	}

	public static function getProviders() {
        $providers['unsplash'] = new UnsplashFinder;
        $providers['pexels'] = new PexelsFinder;
        $providers['pixabay'] = new PixabayFinder;
        return $providers;
	}

	public function extendMediaManager() {

		if (class_exists('System'))  {
			$manager = \Media\Widgets\MediaManager::class;
		} else {
			$manager = \Backend\Widgets\MediaManager::class;
		}
		
		$manager::extend(function($widget) {

			$widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/partials/editor/');
            $widget->addViewPath(plugins_path().'/snipi/uniquemediafinder/partials/');
            $widget->addJs('/plugins/snipi/uniquemediafinder/assets/js/mediaFinder.js');
            $widget->addCss('/plugins/snipi/uniquemediafinder/assets/css/mediaFinder.css');

			$widget->addDynamicMethod('isConfigured', function(){
				if($this->providers['unsplash']->configured() || $this->providers['pexels']->configured() || $this->providers['pixabay']->configured()) {
					return true;
				}
				return false;
			});

			$widget->addDynamicMethod('getProviders', function() use ($widget) {
				return $this->providers;
			});

			$widget->addDynamicMethod('onInitProvider', function() use ($widget) {
				$data = Input::all();

				$randomPhotos = $this->providers[$data['provider']]->loadRandom();
				$widget->vars['provider'] = $data['provider'];				
				$widget->vars['items'] = $randomPhotos;       
				$widget->vars['currentProvider'] = $this->providers[$data['provider']];         
                
			});

			$widget->addDynamicMethod('onFeedback', function() use ($widget){

				Mail::raw([
				    'html' => '<p><strong>'.Input::get('your_name') . '</strong> sent feedback form from plugin.</p><p><strong>Feedback message:</strong><br/>' . Input::get('your_message'). '</p><p><strong>Contact:</strong><br/>' . Input::get('your_email').'</p>'
				], function ($message) {
					$message->to('snipiba@gmail.com','Snipi');
					$message->subject('Feedback from Unique Media Finder plugin');
				    //
				});
			});

			$widget->addDynamicMethod('onLoadFilters', function() use ($widget){

				$widget->vars['provider'] = Input::get('provider');

			});

			$widget->addDynamicMethod('onSearchProvider', function() use ($widget){

				$provider = Input::get('provider');				
				parse_str(Input::get('filters'), $filters);
				foreach($filters as $key => $v) {
					if($key == 'qs') {
						$qs = $v;
					} else {
						$options[$key] = $v;
					}
					
				}

				$data = $this->providers[$provider]->search($qs, $options, Input::get('page') ?? 1);
				$widget->vars['items'] = $data['results'];
				$widget->vars['data'] = $data;
				$widget->vars['provider'] = $provider;
				$widget->vars['search'] = $qs;
				$widget->vars['page'] = Input::get('page') ?? 0;
				$widget->vars['currentProvider'] = $this->providers[$provider];        

				if(Settings::get('store_search')) {
					$s = new Search;
					$s->provider = $provider;
					$s->search_query = $qs;
					$s->search_parameters = json_encode($options);
					$s->response = $data;
					$s->user_id = BackendAuth::getUser()->id;
					$s->save();
				}

			});

			$widget->addDynamicMethod('onPaginate',function() use($widget){
				$qs = Input::get('query');
				$page = Input::get('page');
				$provider = Input::get('provider');


			});

			$widget->addDynamicMethod('onShowDetails', function() use ($widget){
				$provider = Input::get('provider');
				$id = Input::get('id');
				$data = $this->providers[$provider]->getPhoto($id);
				$widget->vars['photo'] = $data;
				$widget->vars['provider'] = $provider;
				$widget->vars['id'] = $id;
				return $widget->makePartial($provider .'/details', ['photo' => $data]);
			});

			$widget->addDynamicMethod('onAbout', function() use ($widget){
				return $widget->makePartial('editor/' . Lang::getLocale().'/about');
			});

			$widget->addDynamicMethod('onDownload', function() use ($widget){
				$provider = Input::get('provider');
				$this->providers[$provider]->downloadPhoto(Input::get('id'));
				
			});

			if(Settings::get('store_metadata')) {
				$widget->addDynamicMethod('onLoadMetadata', function() use ($widget){
					
					$data = MetadataInformations::where('filename', basename(Input::get('path')))->first();
					if($data) {
						$widget->vars['metadata'] = $data;
					}
					return $widget->makePartial('ajax/metadata', ['metadata'=>$data]);
				});

				$widget->bindEvent('file.rename', function ($originalPath, $newPath) {
			        // Update custom references to path here

			        $origFile = MetadataInformations::where('filename', basename($originalPath))->first();
			        if($origFile) {
				        $origFile->filename = basename($newPath);
				        $origFile->full_path = $newPath;
				        $origFile->save();
				    }
			    });

				$widget->bindEvent('file.move', function ($originalPath, $newPath) {
					$filename = basename($originalPath);
			        $origFile = MetadataInformations::where('filename', basename($originalPath))->first();
			        if($origFile) {
				        $origFile->filename = basename($originalPath);
				        $origFile->full_path = $newPath.'/'.$filename;
				        $origFile->save();
				    }
			    });

				$widget->bindEvent('file.delete', function ($originalPath) {
			        // Update custom references to path here
			        $origFile = MetadataInformations::where('filename', basename($originalPath))->first();
			        if($origFile) {
				        $origFile->delete();
				    }
			    });


				$widget->bindEvent('folder.rename', function ($originalPath, $newPath) {

			        $items = MetadataInformations::where('full_path','like', '%'.$originalPath.'%')->get();
			        foreach($items as $item) {
			        	$item->full_path = str_replace($originalPath, $newPath, $item->full_path);
			        	$item->save();
			        }
			        
			    });

				$widget->bindEvent('folder.delete', function ($originalPath) {
			        // Update custom references to path here
			        $items = MetadataInformations::where('full_path','like', '%'.$originalPath.'%')->delete();
			        
			    });

			}
		});
	}

}