<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameDevicesSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_devices_session',function(Blueprint $table){

            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('token');
            $table->string('refresh_token');
            $table->dateTime('expire_datetime');
            $table->text('params')->nullable();
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
        Schema::drop('game_devices_session');
    }
}
