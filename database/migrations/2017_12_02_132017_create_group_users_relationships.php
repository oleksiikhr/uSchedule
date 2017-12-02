<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUsersRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_users', function (Blueprint $table) {
            $table->index('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('role_id');
            $table->foreign('role_id')->references('id')->on('group_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropIndex(['group_id']);

            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['role_id']);
            $table->dropIndex(['role_id']);
        });
    }
}
