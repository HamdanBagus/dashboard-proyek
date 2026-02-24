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
        Schema::create('photo_outputs', function (Blueprint $table) {
        $table->id();
        // Output biasanya terikat ke Laporan Proyek (Global per project foto)
        $table->foreignId('photo_report_id')->constrained('photo_reports')->onDelete('cascade');

        $table->string('filename'); // Jenis Output (Ex: Orthophoto)
        $table->string('format'); // TIF, ECW, dll
        $table->double('size_gb', 8, 2)->nullable(); // Ukuran GB
        $table->string('location')->nullable(); // Path/Lokasi
        $table->boolean('checklist')->default(false); // Sudah ada?

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_outputs');
    }
};
