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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus');
            $table->integer('diskon_persen')->nullable();
            $table->decimal('diskon_nominal', 10, 2)->nullable();
            $table->enum('tipe_diskon', ['Persen', 'Nominal']);
            $table->dateTime('mulai_diskon');
            $table->dateTime('akhir_diskon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
