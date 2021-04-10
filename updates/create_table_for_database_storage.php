<?php 
namespace SNiPI\UniqueMediaFinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProvidersInformations extends Migration
{

    public function up()
    {
        Schema::create('snipi_uniquemediafinder_providers_informations', function($table)
        {

            $table->bigIncrements('id');
            $table->string('provider')->nullable();
            $table->string('filename')->nullable();
            $table->longText('raw_data')->nullable();
            $table->string('author')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
	{
	    Schema::dropIfExists('snipi_uniquemediafinder_providers_informations');
	} 

}