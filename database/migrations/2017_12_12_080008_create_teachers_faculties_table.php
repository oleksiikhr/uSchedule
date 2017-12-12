<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers_faculties', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('faculty_id');

            $table->foreign('teacher_id')->references('id')->on('subjects')
                ->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');

            $table->index(['teacher_id', 'faculty_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers_faculties');
    }
}
