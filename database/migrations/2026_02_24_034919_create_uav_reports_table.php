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
        Schema::create('uav_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        // Luas Area of Interest (Target yang harus dicapai)
        $table->double('aoi_size', 15, 2)->default(0);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uav_reports');
    }
};
