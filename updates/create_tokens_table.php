<?php namespace Grohman\Socialite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTokensTable extends Migration
{

    public function up()
    {
        $this->down();
        Schema::create('grohman_socialite_tokens', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('provider_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('social_id');
            $table->string('social_token');
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('grohman_socialite_providers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grohman_socialite_tokens');
    }

}
