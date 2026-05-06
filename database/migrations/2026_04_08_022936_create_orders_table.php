<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // BITERITO-XXXX
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('delivery_address');
            $table->string('order_type'); // preorder / bazar
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status')->default('unchecked'); // unchecked/paid
            $table->string('order_status')->default('waiting'); // waiting/process/ready/delivered
            $table->string('payment_proof')->nullable(); // path file bukti bayar
            $table->timestamp('scheduled_pickup')->nullable(); // untuk preorder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
