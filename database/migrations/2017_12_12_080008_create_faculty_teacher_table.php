<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_teacher', function (Blueprint $table) {
            $table->unsignedInteger('faculty_id');
            $table->unsignedInteger('teacher_id');

            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('subjects')
                ->onDelete('cascade');

            $table->index(['faculty_id', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_teacher');
    }
}
