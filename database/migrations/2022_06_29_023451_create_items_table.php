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
            $table->text('item_it')->nullable();
            $table->string('quanty_it')->nullable();
            $table->string('qty_boxes_it')->nullable();
            $table->text('ubication_it');
            $table->text('observation_it')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_customer_id')->nullable()->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('status_id')->constrained('status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('shipment_id')->nullable()->constrained('shipments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('cascade')->onUpdate('cascade');
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
