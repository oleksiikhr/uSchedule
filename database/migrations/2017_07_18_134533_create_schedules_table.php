<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('degree', 60);
            $table->string('daytime', 60);
            $table->tinyInteger('course');
            $table->integer('group_id');
            $table->integer('faculty_id');
            $table->timestamps();
        });

        // TODO: del in future. Simple/Test record.
        DB::table('schedules')->insert([
            'degree'     => 'bachelor',
            'daytime'    => 'daytime',
            'course'     => 1,
            'group_id'   => 1,
            'faculty_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
