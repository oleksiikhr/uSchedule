<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsFacultiesTable extends Migration
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
        Schema::create('subjects_faculties', function (Blueprint $table) {
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('faculty_id');

            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');

            $table->index(['subject_id', 'faculty_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects_faculties');
    }
}
