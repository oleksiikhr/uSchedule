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
            $table->string('degree', 60);
            $table->string('daytime', 60);
            $table->tinyInteger('course');
            $table->integer('group_id')->unsigned();
            $table->integer('faculty_id')->unsigned();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');

            $table->index(['group_id', 'faculty_id']);
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
