<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // "QRIS", "BCA VA", "Mandiri VA"
            $table->string('code')->nullable();  // internal code, e.g. 'qris','va_bca'
            $table->string('type')->nullable();  // e.g. 'qris' or 'va'
            $table->json('details')->nullable(); // json for bank number, qrcode url, etc
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
