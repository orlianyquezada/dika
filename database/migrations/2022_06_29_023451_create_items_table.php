<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->datetime('datetime_it');
            $table->text('item_it');
            $table->string('quanty_it');
            $table->string('qty_boxes_it');
            $table->text('ubication_it');
            $table->text('observation_it');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('status_id')->constrained('status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('shipment_id')->nullable()->constrained('shipments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('movement_id')->nullable();
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
        Schema::dropIfExists('items');
    }
}
