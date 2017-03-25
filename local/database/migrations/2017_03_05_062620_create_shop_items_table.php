<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_items',function(Blueprint $table){

            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')
                ->references('id')->on('games')
                ->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('type')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('price')->unsigned()->defaul(0);
            $table->boolean('free_item')->default(1);
            $table->string('logo');
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
        Schema::drop('game_items');
    }
}
