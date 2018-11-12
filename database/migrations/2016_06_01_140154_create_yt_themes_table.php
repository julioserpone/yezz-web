<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYtThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yt_themes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('yt_theme_statuses_id')->unsigned();
            $table->foreign('yt_theme_statuses_id')->references('id')->on('yt_theme_statuses');
            $table->integer('yt_categories_id')->unsigned();
            $table->foreign('yt_categories_id')->references('id')->on('yt_categories');
            $table->string('ext_id',255)->unique();
            $table->string('title',100);
            $table->string('summary',4000);
            $table->string('content',4000);
            $table->string('highlight_one',100);
            $table->string('highlight_two',100);
            $table->string('highlight_three',100);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->integer('active')->default(1);
            $table->string('createdBy',50);
            $table->string('updatedby',50);
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
        Schema::drop('yt_themes');
    }
}
