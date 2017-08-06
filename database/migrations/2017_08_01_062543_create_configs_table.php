<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('value');
            $table->timestamps();
        });

        DB::table('configs')->insert([
            'name'  => 'time',
            'value' => serialize([
                ['8:20', '9:40'], ['9:55', '11:15'], ['11:50', '13:10'], ['13:30', '14:50'],
                ['15:00', '16:20'], ['16:30', '17:50'], ['18:00', '19:20'],
            ])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
