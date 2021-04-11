<?php namespace SNiPI\UniqueMediaFinder\Models;

use Model;

/**
 * MetadataInformations Model
 */
class MetadataInformations extends Model
{
    /**
     * @var string The database table used by the model.
     */

   
    public $timestamps = true;

    public $table = 'snipi_uniquemediafinder_providers_informations';

    protected $primaryKey = 'id';
    protected $jsonable = ['raw_data'];

    public $belongsTo = [
    	'user' => ['Backend\Models\User']
    ];

}
