<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDayTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_day_teachers', function (Blueprint $table) {
            $table->integer('schedule_day_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->timestamps();

            $table->foreign('schedule_day_id')->references('id')->on('schedule_days')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index(['schedule_day_id', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_day_teachers');
    }
}
