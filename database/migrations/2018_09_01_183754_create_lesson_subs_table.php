<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_subs', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('type_id');
            $table->string('cabinet')->nullable();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('lesson_types')->onDelete('cascade');

            $table->primary(['teacher_id', 'lesson_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_subs');
    }
}
