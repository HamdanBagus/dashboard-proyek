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
        Schema::create('uav_pilot_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('uav_report_id')->constrained('uav_reports')->onDelete('cascade');

        // Data Penerbangan
        $table->date('date'); // Tanggal Terbang

        // Relasi ke Tabel Karyawan & Aset (Dropdown)
        $table->foreignId('pilot_id')->constrained('employees'); // Nama Pilot
        $table->foreignId('assistant_id')->nullable()->constrained('employees'); // Asisten Pilot
        $table->foreignId('uav_id')->constrained('asset_uavs'); // Unit Drone

        // Statistik Harian
        $table->integer('flight_count')->default(0); // Jml Flight
        $table->double('area_acquired', 15, 2)->default(0); // Luas yg didapat (Ha)

        // Status & Catatan
        // Opsi: Persiapan, Finished Flight, Reflight, RTH, Hujan, Maintenance UAV
        $table->string('status');
        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uav_pilot_logs');
    }
};
