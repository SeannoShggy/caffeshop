<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_id')->unique(); // ORDxxxx
            $table->string('customer_name');
            $table->string('phone')->nullable();

            $table->json('cart'); // daftar pesanan
            $table->text('note')->nullable();

            $table->integer('total');

            // status pesanan
            $table->enum('status', ['pending','done'])
                  ->default('pending');

            // status pembayaran
            $table->enum('payment_status', ['pending','paid'])
                  ->default('pending');

            // bukti pembayaran
            $table->string('payment_proof')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
