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
        Schema::create('qc_uav_photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Pilihan Alat (Multiple Select disimpan dalam bentuk JSON)
        $table->json('uav_used')->nullable();
        $table->json('camera_used')->nullable();

        // Checklist Kelengkapan & Keterangan
        $table->boolean('chk_raw_photo')->default(0);
        $table->string('note_raw_photo')->nullable();

        $table->boolean('chk_raw_uav')->default(0);
        $table->string('note_raw_uav')->nullable();

        $table->boolean('chk_base_gps')->default(0);
        $table->string('note_base_gps')->nullable();

        $table->boolean('chk_geotag')->default(0);
        $table->string('note_geotag')->nullable();

        // Path File Bukti Pengecekan Kualitas (Screenshot)
        $table->string('file_quality')->nullable();
        $table->string('file_geotag')->nullable();
        $table->string('file_blur')->nullable();
        $table->string('file_overlap')->nullable();
        $table->string('file_gsd')->nullable();

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
        Schema::dropIfExists('qc_uav_photos');
    }
};
