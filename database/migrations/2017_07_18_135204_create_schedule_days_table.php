<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
            $table->integer('subject_id');
            $table->integer('teacher_id');
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('order');
            $table->string('room', 10)->nullable();
            $table->tinyInteger('type'); // 0 - Лекция, 1 - Практика, 2 - Лб1, 3 - Лб2
            $table->tinyInteger('is_empty'); // 0 - не пустая, 1 - пустая
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
        Schema::dropIfExists('schedule_days');
    }
}
