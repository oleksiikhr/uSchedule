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
        /**
         * @see RelationShipUsersTable
         *
         * @see CreateObjectsTable object_id
         * @see CreateGroupsTable group_id
         */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 35)->nullable();
            $table->string('middle_name', 35)->nullable();
            $table->string('last_name', 35)->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('object_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
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
