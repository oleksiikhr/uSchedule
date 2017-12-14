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
        /**
         * @see CreateLessonsTable lesson_id
         * @see CreateTeachersTable teacher_id
         * @see CreateLessonTypesTable type_id
         */
        Schema::create('lesson_subs', function (Blueprint $table) {
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->string('cabinet', 10);

            $table->foreign('lesson_id')->references('id')->on('lessons')
                ->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('lesson_types')
                ->onDelete('set null');

            $table->index(['lesson_id', 'teacher_id', 'type_id']);
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