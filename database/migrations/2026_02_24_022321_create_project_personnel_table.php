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
        Schema::create('project_personnel', function (Blueprint $table) {
        $table->id();

        // Menghubungkan ke tabel projects
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Menghubungkan ke tabel employees
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

        // Peran spesifik di proyek ini (PM, Surveyor, Pilot, dll)
        $table->string('role');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_personnel');
    }
};
