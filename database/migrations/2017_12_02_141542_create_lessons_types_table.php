<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('object_id');
            $table->string('name', 60);
            $table->string('display_name');

            $table->foreign('object_id')->references('id')->on('objects')
                ->onDelete('cascade');

            $table->index('object_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_types');
    }
}
