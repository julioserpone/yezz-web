<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYtCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yt_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('yt_themes_id')->unsigned();
            $table->foreign('yt_themes_id')->references('id')->on('yt_themes');
            $table->string('parent_id',20);
            $table->string('ext_id',255)->unique();
            $table->string('answer', 900);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->integer('active')->default(1);
            $table->integer('yt_banreasons_id')->default(0);
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
        Schema::drop('yt_comments');
    }
}
