<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->dropForeign('users_object_id_foreign');
            $table->dropForeign('users_group_id_foreign');

            $table->dropIndex('users_object_id_group_id_index');
        });
    }
}
