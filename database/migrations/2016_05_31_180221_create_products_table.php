<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operating_system_id')->unsigned();
            $table->foreign('operating_system_id')->references('id')->on('operating_systems');
            $table->string('ext_id',100);
            $table->string('model',50);
            $table->string('model_id',50);
            $table->string('line',50)->nullable();
            $table->integer('category_id')->nullable();
            $table->string('partNumber',50)->nullable();
            $table->date('releaseDate')->nullable();
            $table->string('parent',50)->nullable();
            $table->string('variantModel',50)->nullable();
            $table->string('variantPartNumber',50)->nullable();
            $table->integer('top')->default(0);
            $table->integer('active')->default(1);
            $table->integer('manual')->default(0);
            $table->integer('catalog')->default(0);
            $table->integer('doc')->default(0);
            $table->integer('video')->default(0);
            $table->string('sales_guide_en',100)->nullable();
            $table->string('sales_guide_es',100)->nullable();
            $table->string('yezztore_url',1000)->nullable();
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
        Schema::drop('products');
    }
}
