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
            $table->unsignedInteger('object_id');
            $table->unsignedInteger('faculty_id');
            $table->unsignedInteger('group_id');
            $table->integer('course');
            $table->integer('daytime'); // TODO: Look later*

            $table->foreign('object_id')->references('id')->on('objects')
                ->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade');

            $table->index(['object_id', 'faculty_id', 'group_id']);
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
