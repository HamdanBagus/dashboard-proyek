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
        Schema::create('qc_uav_lidars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Pilihan Alat (Multiple Select)
        $table->json('uav_used')->nullable();
        $table->json('camera_used')->nullable();

        // Checklist Kelengkapan & Keterangan
        $table->boolean('chk_raw_lidar')->default(0);
        $table->string('note_raw_lidar')->nullable();

        $table->boolean('chk_base_gps')->default(0);
        $table->string('note_base_gps')->nullable();

        $table->boolean('chk_pre_processing')->default(0);
        $table->string('note_pre_processing')->nullable();

        // Path File Bukti Pengecekan Kualitas (Screenshot)
        $table->string('file_gap')->nullable();       // Bukti tidak ada gap
        $table->string('file_accuracy')->nullable();  // Bukti akurasi vertikal

        // Footer / Petugas
        $table->date('qc_date')->nullable();
        $table->string('qc_officer_name')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_uav_lidars');
    }
};
