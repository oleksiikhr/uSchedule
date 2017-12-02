<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * NOTE: Table may not be used in the Objects table.
         *
         * @see CreateObjectsTable object_id
         */
        Schema::create('faculties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('object_id');
            $table->string('name');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('faculties');
    }
}
