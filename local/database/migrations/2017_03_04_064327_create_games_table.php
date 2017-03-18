<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games',function(Blueprint $table){

            $table->increments('id');
            $table->integer('category_id')->unsigned();
            //TODO publisher_id is for next generation of service
            $table->integer('publisher_id')->default(0);
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
            $table->string('package_name')->unique();
            $table->string('title');
            $table->string('logo');
            $table->integer('download_count')->unsigned()->default(0);
            $table->text('previews')->nullable();
            $table->text('description')->nullable();
            $table->text('params')->nullable();
            $table->string('api_key',20)->unique();
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
        Schema::drop('games');
    }
}
