<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id',50)->unique();
            $table->integer('language_id');
            $table->integer('position');
            $table->string('name',955);
            $table->string('url',955);
            $table->string('image_url',955)->nullable();
            $table->string('usr_define1',955)->nullable();
            $table->string('usr_define2',955)->nullable();
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
        Schema::drop('journals');
    }
}
