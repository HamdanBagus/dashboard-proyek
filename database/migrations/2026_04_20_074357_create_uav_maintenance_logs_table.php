<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uav_maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('uav_id')->constrained('asset_uavs')->onDelete('cascade');
            
            $table->string('pilot_name')->nullable();
            
            // Angka Sebelum Proyek
            $table->integer('km_before')->nullable();
            $table->integer('flight_count_before')->nullable();
            $table->integer('flight_hours_before')->nullable();
            
            // Angka Sesudah Proyek
            $table->integer('km_after')->nullable();
            $table->integer('flight_count_after')->nullable();
            $table->integer('flight_hours_after')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uav_maintenance_logs');
    }
};