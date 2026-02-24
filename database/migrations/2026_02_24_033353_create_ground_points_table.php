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
        Schema::create('ground_points', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ground_report_id')->constrained('ground_reports')->onDelete('cascade');

        $table->string('name'); // Nama Titik (misal: BM-01)

        // 1. TAHAP PEMASANGAN
        $table->boolean('install_status')->default(false); // Checklist Selesai
        $table->date('install_date')->nullable();
        $table->string('install_surveyor')->nullable(); // Nama Surveyor (string dulu biar simpel)

        // 2. TAHAP PENGUKURAN
        $table->boolean('measure_status')->default(false);
        $table->date('measure_date')->nullable();
        $table->string('measure_surveyor')->nullable();

        // 3. TAHAP PENGOLAHAN
        $table->boolean('process_status')->default(false);
        $table->date('process_date')->nullable();
        $table->string('process_surveyor')->nullable(); // Nama Pengolah Data

        $table->text('notes')->nullable(); // Catatan umum

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ground_points');
    }
};
