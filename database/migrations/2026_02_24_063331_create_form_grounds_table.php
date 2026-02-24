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
        Schema::create('form_grounds', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Isian Manual Staff/Admin
        $table->string('planned_control_points')->nullable(); // Jumlah rencana titik kontrol
        $table->string('point_codes')->nullable(); // Kode nama titik yang digunakan
        $table->string('planned_tie_points')->nullable(); // Rencana titik ikat yang akan digunakan

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_grounds');
    }
};
