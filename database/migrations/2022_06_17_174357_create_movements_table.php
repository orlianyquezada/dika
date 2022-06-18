<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_mo');
            $table->text('item_mo')->nullable();
            $table->string('quanty_mo')->nullable();
            $table->string('qty_boxes_mo')->nullable();
            $table->text('ubication_mo');
            $table->text('observation_mo')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('status_id')->constrained('status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('shipment_id')->nullable()->constrained('shipments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('movement_id')->nullable()->constrained('movements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('movements');
    }
}
