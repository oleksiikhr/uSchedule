<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateUsersTable captain_id
         * @see CreateFacultiesTable faculty_id
         */
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('faculty_id')->nullable();
            $table->string('name');
            $table->tinyInteger('course');
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');

            $table->index('faculty_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
