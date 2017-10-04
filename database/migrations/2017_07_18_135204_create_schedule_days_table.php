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
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('order');
            $table->string('room', 30)->nullable();
            $table->tinyInteger('type'); // 0 - Лекция, 1 - Практика, 2 - Лб1, 3 - Лб2
            $table->boolean('is_empty');
            $table->integer('schedule_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')
                ->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('cascade');

            $table->index(['schedule_id', 'subject_id']);
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
