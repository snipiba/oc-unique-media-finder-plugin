<?php 
namespace SNiPI\UniqueMediaFinder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSearchesTable extends Migration
{

    public function up()
    {
        Schema::create('snipi_uniquemediafinder_searches', function($table)
        {

            $table->bigIncrements('id');
            $table->string('provider')->nullable();
            $table->string('search_query')->nullable();
            $table->string('search_parameters')->nullable();
            $table->boolean('uses_cache')->default(0)->nullable();
            $table->longText('response')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();

        });
    }

    public function down()
	{
	    Schema::dropIfExists('snipi_uniquemediafinder_searches');
	} 

}