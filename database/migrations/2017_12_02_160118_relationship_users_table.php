<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateUsersTable
         */
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('object_id')->references('id')->on('objects')
                ->onDelete('set null');
            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('set null');

            $table->index(['object_id', 'group_id']);
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
            $table->dropForeign(['object_id', 'group_id']);
            $table->dropIndex(['object_id', 'group_id']);
        });
    }
}
