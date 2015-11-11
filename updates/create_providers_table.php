<?php namespace Grohman\Socialite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProvidersTable extends Migration
{

    public function up()
    {
        $this->down();
        Schema::create('grohman_socialite_providers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('client_name');
            $table->string('client_id');
            $table->string('client_secret');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grohman_socialite_providers');
    }

}
