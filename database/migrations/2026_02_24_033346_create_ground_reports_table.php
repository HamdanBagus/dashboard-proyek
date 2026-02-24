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
        Schema::create('ground_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Informasi Umum Tim Ground
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        // Keterangan Jumlah Titik (Target)
        $table->integer('bm_count')->default(0);  // Benchmark
        $table->integer('icp_count')->default(0); // Independent Check Point
        $table->integer('gcp_count')->default(0); // Ground Control Point
        $table->integer('other_count')->default(0); // Titik Tambahan

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ground_reports');
    }
};
