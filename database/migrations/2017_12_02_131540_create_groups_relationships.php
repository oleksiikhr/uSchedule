<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->index('captain_id');
            $table->foreign('captain_id')->references('id')->on('users')->onDelete('set null');

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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['captain_id']);
            $table->dropIndex(['captain_id']);

            $table->dropForeign(['faculty_id']);
            $table->dropIndex(['faculty_id']);
        });
    }
}
