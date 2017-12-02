<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @see CreateObjectsTable
         *
         * @see CreateObjectsTypesTable type_id
         */
        Schema::table('objects', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('objects_types')
                ->onDelete('set null');

            $table->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropIndex(['type_id']);
        });
    }
}
