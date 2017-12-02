<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsFacultiesRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects_faculties', function (Blueprint $table) {
            $table->index('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->index('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects_faculties', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropIndex(['subject_id']);

            $table->dropForeign(['faculty_id']);
            $table->dropIndex(['faculty_id']);
        });
    }
}
