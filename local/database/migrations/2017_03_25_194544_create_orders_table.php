<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders',function(Blueprint $table){

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('game_item_id')->unsigned();
            $table->integer('price')->unsigned()->default(0);
            $table->boolean('pay')->default(0);
            $table->boolean('valid')->default(1);
            $table->dateTime('start_time');
            $table->dateTime('finish_time')->nullable();
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
        Schema::drop('orders');
    }
}
