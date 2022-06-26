<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_movements', function (Blueprint $table) {
            $table->id();
            $table->datetime('datetime_exm');
            $table->text('address_exm');
            $table->text('observation_exm');
            $table->foreignId('input_movement_id')->constrained('input_movements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('status_id')->constrained('status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('exit_movements');
    }
}
