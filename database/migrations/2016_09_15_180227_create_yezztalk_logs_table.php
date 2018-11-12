<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYezztalkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yezztalk_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('entity',100);
            $table->string('ext_id',955);
            $table->string('action',100);
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
        Schema::drop('yezztalk_logs');
    }
}
