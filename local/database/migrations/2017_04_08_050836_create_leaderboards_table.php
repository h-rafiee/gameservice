<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_leaderboards',function(Blueprint $table){

            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('logo');
            $table->text('params')->nullable();
            $table->timestamps();

        });

        Schema::create('user_game_leaderboards',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_game_id')->unsigned();
            $table->foreign('user_game_id')
                ->references('id')->on('user_games')
                ->onDelete('cascade');
            $table->integer('game_leaderboard_id')->unsigned();
            $table->foreign('game_leaderboard_id')
                ->references('id')->on('game_leaderboards')
                ->onDelete('cascade');
            $table->bigInteger('score')->unsigned()->default(0);
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
        Schema::drop('user_game_leaderboards');
        Schema::drop('game_leaderboards');
    }
}
