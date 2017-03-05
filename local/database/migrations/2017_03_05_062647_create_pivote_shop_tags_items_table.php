<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivoteShopTagsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("pivot_shop_tags_items",function(Blueprint $table){
            $table->integer('shop_tag_id')->unsigned();
            $table->foreign('shop_tag_id')
                ->references('id')->on('shop_tags')
                ->onDelete('cascade');
            $table->integer('shop_item_id')->unsigned();
            $table->foreign('shop_item_id')
                ->references('id')->on('shop_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pivot_shop_tags_items');
    }
}
