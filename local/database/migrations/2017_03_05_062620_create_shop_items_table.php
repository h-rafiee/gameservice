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
        Schema::create('shop_items',function(Blueprint $table){

            $table->increments('id');
            $table->integer('game_shop_id')->unsigned();
            $table->foreign('game_shop_id')
                ->references('id')->on('game_shop')
                ->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('price')->unsigned()->defaul(0);
            $table->boolean('free_item')->default(1);
            $table->string('logo');
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
        Schema::drop('shop_items');
    }
}
