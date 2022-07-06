<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignIdExitMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_movements', function (Blueprint $table) {
            $table->dropForeign('exit_movements_input_movement_id_foreign');
            $table->dropForeign('exit_movements_customer_id_foreign');
            $table->dropForeign('exit_movements_condition_id_foreign');
            $table->dropForeign('exit_movements_status_id_foreign');
            $table->dropForeign('exit_movements_shipment_id_foreign');
            $table->dropForeign('exit_movements_employee_id_foreign');
            $table->dropForeign('exit_movements_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_movements', function (Blueprint $table) {
            //
        });
    }
}
