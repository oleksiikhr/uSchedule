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
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('captain_id')->nullable();
            $table->unsignedInteger('faculty_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('captain_id')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');

            $table->index(['captain_id', 'faculty_id']);
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
