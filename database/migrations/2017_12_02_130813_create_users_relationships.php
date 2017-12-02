<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');

            $table->index('object_id');
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropIndex(['group_id']);

            $table->dropForeign(['object_id']);
            $table->dropIndex(['object_id']);

        });
    }
}
