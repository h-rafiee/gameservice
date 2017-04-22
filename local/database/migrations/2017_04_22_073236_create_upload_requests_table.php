<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads_requests',function(Blueprint $table){

            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('access');
            $table->boolean('uploaded')->default(0);
            $table->dateTime('expired_time');
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
        Schema::drop('uploads_requests');
    }
}
