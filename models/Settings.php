<?php 
namespace Snipi\UniqueMediaFinder\Models;

use October\Rain\Database\Model;

/**
 * Google Analytics settings model
 *
 * @package system
 * @author Alexey Bobkov, Samuel Georges
 *
 */
class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'snipi_unique_media_finder';

    public $settingsFields = 'fields.yaml';

    public $attachOne = [
        'gapi_key' => ['System\Models\File', 'public' => false]
    ];

    /**
     * Validation rules
     */
    public $rules = [
        'api_key'   => 'required_with:api_secret',
        'api_secret'   => 'required_with:api_key',
    ];

    public function initSettingsData()
    {
        $this->per_page = 20;
    }
}