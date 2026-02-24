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
        Schema::create('lidar_progress', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lidar_hamparan_id')->constrained('lidar_hamparans')->onDelete('cascade');

        $table->string('stage_name'); // Tahapan (Ex: Klasifikasi Ground)
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('processor_name')->nullable();
        $table->string('pc_name')->nullable();
        $table->string('status')->default('Pending');
        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lidar_progress');
    }
};
