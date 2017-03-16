<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGameItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_game_items',function(Blueprint $table){

            $table->increments('id');
            $table->integer('user_game_id')->unsigned();
            $table->foreign('user_game_id')
                ->references('id')->on('user_games')
                ->onDelete('cascade');
            $table->integer('shop_item_id')->unsigned();
            $table->foreign('shop_item_id')
                ->references('id')->on('shop_items')
                ->onDelete('cascade');
            $table->boolean('used')->default(0);
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
        Schema::drop('user_game_items');
    }
}
