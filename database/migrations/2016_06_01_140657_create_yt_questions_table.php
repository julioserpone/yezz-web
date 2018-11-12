<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYtQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yt_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('yt_theme_id')->unsigned();
            $table->foreign('yt_theme_id')->references('id')->on('yt_themes');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('ext_id',255)->unique();
            $table->integer('questionstatus_id')->unsigned();
            $table->foreign('questionstatus_id')->references('id')->on('yt_questionstatuses');
            $table->string('question', 900);
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
        Schema::drop('yt_questions');
    }
}
