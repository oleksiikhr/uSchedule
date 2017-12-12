<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectLessonsTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateObjectsTable object_id
         */
        Schema::create('object_lessons_time', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('object_id');
            $table->tinyInteger('lesson_num');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('object_id')->references('id')->on('objects')
                ->onDelete('cascade');

            $table->index('object_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_lessons_time');
    }
}
