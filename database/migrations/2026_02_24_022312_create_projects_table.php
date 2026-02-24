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
        Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('name');              // Nama Proyek [cite: 11]
        $table->string('code')->unique();    // Kode Proyek [cite: 11]
        $table->string('client_name');       // Nama Klien [cite: 11]
        $table->text('client_address')->nullable(); // Alamat Klien [cite: 11]
        $table->text('project_location')->nullable(); // Alamat Proyek [cite: 11]
        $table->double('area_size', 15, 2);  // Luas Proyek (bisa koma) [cite: 11]
        $table->date('start_date');          // Tanggal Mulai [cite: 11]
        $table->date('end_date');            // Tanggal Selesai [cite: 11]

        // Status Proyek (Berjalan/Selesai) [cite: 7]
        $table->enum('status', ['planning', 'ongoing', 'finished'])->default('planning');

        // Rencana Jumlah Alat (Inputan Admin di Info Proyek) [cite: 11]
        $table->integer('planned_uav')->default(0);
        $table->integer('planned_lidar')->default(0);
        $table->integer('planned_gps')->default(0);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
