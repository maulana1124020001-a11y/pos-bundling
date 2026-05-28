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
        Schema::create('bundlings', function (Blueprint $table) {
           
        $table->id();
        $table->string('nama_bundling');
        $table->foreignId('menu_a_id')->constrained('menus')->onDelete('cascade');
        $table->foreignId('menu_b_id')->constrained('menus')->onDelete('cascade');
        $table->timestamps();
    });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundlings');
    }
};
