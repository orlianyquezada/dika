<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('input_movements', function (Blueprint $table) {
            $table->dropForeign('input_movements_customer_id_foreign');
            $table->dropForeign('input_movements_condition_id_foreign');
            $table->dropForeign('input_movements_status_id_foreign');
            $table->dropForeign('input_movements_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
