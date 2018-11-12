<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYtAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yt_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('yt_question_id')->unsigned();
            $table->foreign('yt_question_id')->references('id')->on('yt_questions');
            $table->integer('parent_id');
            $table->string('ext_id',255)->unique();
            $table->string('answer', 900);
            $table->integer('positive');
            $table->integer('negative');
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
        Schema::drop('yt_answers');
    }
}
