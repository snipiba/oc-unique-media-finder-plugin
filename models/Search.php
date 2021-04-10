<?php
namespace SNiPI\UniqueMediaFinder\Models;

use Model;

class Search extends Model {
	
	protected $table = 'snipi_uniquemediafinder_searches';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $jsonable = ['response'];
}