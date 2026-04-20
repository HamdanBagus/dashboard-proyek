<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uav_component_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uav_maintenance_log_id')->constrained('uav_maintenance_logs')->onDelete('cascade');
            
            $table->enum('phase', ['sebelum', 'sesudah']); // Menandakan ini dicek kapan
            $table->string('component_name'); // Cth: Baterai, Propeller, dll
            
            // Hasil Pengecekan
            $table->string('completeness')->nullable(); // Isian teks kelengkapan
            $table->enum('condition', ['baik', 'rusak', 'tidak_ada'])->default('baik');
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uav_component_checks');
    }
};