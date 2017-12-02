<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_subs', function (Blueprint $table) {
            $table->integer('lesson_id')->unsigned();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->string('cabinet', 10);

            $table->index('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');

            $table->index('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');

            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('lessons_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_subs');
    }
}
