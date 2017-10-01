<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        TODO: add role in future
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_edit')->default(0);
            $table->integer('group_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');

            $table->index('group_id');
        });

        DB::table('users')->insert([
            'email'    => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
