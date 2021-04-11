<?php 
namespace SNiPI\UniqueMediaFinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddFullPathToMetadataTable extends Migration
{

    public function up()
    {
        Schema::table('snipi_uniquemediafinder_providers_informations', function($table)
        {

            $table->text('full_path')->nullable();
        });
    }

    public function down()
	{
	    Schema::table('snipi_uniquemediafinder_providers_informations', function($table){
            $table->dropColumnIfExists('full_path');
        });
	} 

}