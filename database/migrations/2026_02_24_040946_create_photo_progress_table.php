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
        Schema::create('photo_progress', function (Blueprint $table) {
        $table->id();
        $table->foreignId('photo_hamparan_id')->constrained('photo_hamparans')->onDelete('cascade');

        $table->string('stage_name'); // Nama Tahapan (Ex: Aerotriangulasi)

        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        $table->string('processor_name')->nullable(); // Nama Pengolah
        $table->string('pc_name')->nullable(); // PC yang digunakan

        $table->string('status')->default('Pending'); // Pending/Proses/Selesai/Gagal
        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_progress');
    }
};
