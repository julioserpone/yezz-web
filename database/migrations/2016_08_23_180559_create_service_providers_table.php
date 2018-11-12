<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id',50)->unique();
            $table->string('name',100);
            $table->string('country',20);
            $table->string('province',50);
            $table->string('email',100);
            $table->string('phone_number',100);
            $table->string('address',900);
            $table->string('latitude',20);
            $table->string('longitude',20);
            $table->string('attention',50);
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
        Schema::drop('service_providers');
    }
}
