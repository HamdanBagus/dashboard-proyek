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
        Schema::create('form_uavs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Isian Manual Staff/Admin
        $table->string('product_specs')->nullable(); // Spesifikasi Produk (GSD, Ketelitian dll)
        $table->integer('planned_takeoffs')->nullable(); // Jumlah Rencana titik Take Off

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_uavs');
    }
};
