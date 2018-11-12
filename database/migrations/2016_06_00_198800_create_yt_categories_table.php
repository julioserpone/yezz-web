<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYtCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yt_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('yt_categorystatuses_id')->unsigned();
            $table->foreign('yt_categorystatuses_id')->references('id')->on('yt_categorystatuses');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('ext_id',255)->unique();
            $table->string('name',100);
            $table->integer('likes')->default(0);
            $table->integer('unlikes')->default(0);
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yt_categories');
    }
}
