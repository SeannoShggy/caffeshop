<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // relasi produk (nullable agar tidak gagal bila produk dihapus)
            $table->unsignedBigInteger('product_id')->nullable()->index();

            // kuantitas & harga
            $table->integer('quantity')->default(1);
            $table->bigInteger('price')->default(0); // harga per item
            $table->bigInteger('total')->default(0); // quantity * price

            // tanggal transaksi (nullable agar mudah diisi setelah create)
            $table->timestamp('transaction_date')->nullable();

            // tipe transaksi: sale / purchase / adjustment
            $table->string('type', 30)->default('sale')->index();

            $table->text('note')->nullable();

            $table->timestamps();

            // foreign key (opsional) — aktifkan jika table products ada dan kamu mau constraint
            // $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
