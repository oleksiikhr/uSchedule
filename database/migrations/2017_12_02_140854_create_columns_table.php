<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateSchedulesTable schedule_id
         */
        Schema::create('columns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->string('name', 100);
            $table->string('description')->nullable();
            $table->smallInteger('order');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')
                ->onDelete('cascade');

            $table->index('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
}
