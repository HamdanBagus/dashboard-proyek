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
        Schema::create('lidar_outputs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lidar_report_id')->constrained('lidar_reports')->onDelete('cascade');

        $table->string('filename'); // Jenis Output (Ex: DTM, Kontur)
        $table->string('format'); // LAS, SHP, DWG
        $table->double('size_gb', 8, 2)->nullable();
        $table->string('location')->nullable();
        $table->boolean('checklist')->default(false);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lidar_outputs');
    }
};
