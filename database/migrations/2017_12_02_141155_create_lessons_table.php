<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('day_id');
            $table->unsignedInteger('subjects_id')->nullable();
            $table->smallInteger('order');
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('days')
                ->onDelete('cascade');
            $table->foreign('subjects_id')->references('id')->on('subjects')
                ->onDelete('set null');

            $table->index(['subjects_id', 'day_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
