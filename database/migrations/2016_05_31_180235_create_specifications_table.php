<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('ext_id',255);
            $table->string('name',100)->nullable();
            $table->string('operating_system',100)->nullable();
            $table->string('dimensions',100)->nullable();
            $table->string('weight',50)->nullable();
            $table->string('chipset',50)->nullable();
            $table->string('cpu_cores',50)->nullable();
            $table->string('cpu',50)->nullable();
            $table->string('gpu',50)->nullable();
            $table->string('simCard',255)->nullable();
            $table->string('simQty',255)->nullable();
            $table->string('gsm_bands',150)->nullable();
            $table->string('threeg_speed',150)->nullable();
            $table->string('threeg_bands',150)->nullable();
            $table->string('fourg_speed',150)->nullable();
            $table->string('fourg_bands',150)->nullable();
            $table->string('displayType',50)->nullable();
            $table->string('displaySize',50)->nullable();
            $table->string('resolution',150)->nullable();
            $table->string('multitouch',50)->nullable();
            $table->string('primary_camera',50)->nullable();
            $table->string('secundary_camera',50)->nullable();
            $table->string('primary_camera_features',150)->nullable();
            $table->string('videoRecording',50)->nullable();
            $table->string('microSDCS',100)->nullable();
            $table->string('internalMemory',50)->nullable();
            $table->string('ram',50)->nullable();
            $table->string('wlan',50)->nullable();
            $table->string('bluetooth',50)->nullable();
            $table->string('gps',50)->nullable();
            $table->string('usb',50)->nullable();
            $table->string('batteryType',50)->nullable();
            $table->string('batteryCapacity',50)->nullable();
            $table->string('batteryRemovable',50)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::drop('specifications');
    }
}
