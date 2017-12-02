<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id')->default(1); // Default student
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('group_roles')
                ->onDelete('cascade');

            $table->index(['group_id', 'user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_users');
    }
}
