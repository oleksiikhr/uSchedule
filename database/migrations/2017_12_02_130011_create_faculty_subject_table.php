<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultySubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateSubjectsTable subject_id
         * @see CreateFacultiesTable faculty_id
         */
        Schema::create('faculty_subject', function (Blueprint $table) {
            $table->unsignedInteger('faculty_id');
            $table->unsignedInteger('subject_id');

            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('cascade');

            $table->index(['faculty_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_subject');
    }
}
