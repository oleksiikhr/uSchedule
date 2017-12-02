<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned();
            $table->integer('faculty_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('course');
            $table->integer('daytime');

            $table->index('object_id');
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');

            $table->index('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');

            $table->index('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
