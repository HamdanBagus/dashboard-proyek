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
        Schema::create('qc_grounds', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Checklist (1 = Lengkap & Sesuai Struktur Folder, 0 = Belum) & Keterangan
        $table->boolean('chk_form_log')->default(0);
        $table->string('note_form_log')->nullable();

        $table->boolean('chk_raw_gps')->default(0);
        $table->string('note_raw_gps')->nullable();

        $table->boolean('chk_report_gps')->default(0);
        $table->string('note_report_gps')->nullable();

        $table->boolean('chk_coordinate')->default(0);
        $table->string('note_coordinate')->nullable();

        $table->boolean('chk_photo_utsb')->default(0);
        $table->string('note_photo_utsb')->nullable();

        // Path File Bukti Pengecekan Kualitas (Screenshot)
        $table->string('file_tolerance')->nullable(); // Bukti ketelitian
        $table->string('file_inacors')->nullable();   // Bukti selisih inacors
        $table->string('file_google_earth')->nullable(); // Bukti plot GE

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
        Schema::dropIfExists('qc_grounds');
    }
};
