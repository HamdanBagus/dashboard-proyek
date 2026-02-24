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
        Schema::create('asset_pcs', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: PC Panther
        $table->string('spec')->nullable(); // Spesifikasi singkat
        $table->string('status')->default('baik'); // baik/rusak
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_pcs');
    }
};
