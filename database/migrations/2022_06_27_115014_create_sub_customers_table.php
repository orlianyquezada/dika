<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('primary_customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('secondary_customer_id')->constrained('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phone_sc')->nullable();
            $table->string('email_sc')->unique()->nullable();
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
        Schema::dropIfExists('sub_customers');
    }
}
