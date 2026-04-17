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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total_harga', 10, 2);
            $table->decimal('uang_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->enum('status', ['proses', 'selesai'])->default('proses');
            $table->enum('metode_pembayaran', ['cash', 'qris', 'transfer'])->default('cash');
            $table->dateTime('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
