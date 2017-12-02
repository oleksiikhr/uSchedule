<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('object_id');
            $table->string('first_name', 35);
            $table->string('middle_name', 35);
            $table->string('last_name', 35);
            $table->string('academic_title')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('teachers');
    }
}
