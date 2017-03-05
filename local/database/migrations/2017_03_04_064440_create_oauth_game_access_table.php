<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthGameAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_game_client',function(Blueprint $table){

            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_game_client');
    }
}
