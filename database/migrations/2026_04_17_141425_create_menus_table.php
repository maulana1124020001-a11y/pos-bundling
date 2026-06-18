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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
           
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->string('nama');
            $table->decimal('modal', 10, 0);
            $table->decimal('harga', 10, 0);
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->string('gambar');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
