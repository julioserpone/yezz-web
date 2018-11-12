<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('ext_id',50)->unique();
            $table->string('name',100);
            $table->string('address1',900)->nullable();
            $table->string('address2',900)->nullable();
            $table->string('email1',50)->nullable();
            $table->string('email2',50)->nullable();
            $table->string('phone1',20)->nullable();
            $table->string('phone2',20)->nullable();
            $table->string('attention',100)->nullable();
            $table->string('latitude',20)->nullable();
            $table->string('longitude',20)->nullable();
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
        Schema::drop('sellers');
    }
}
