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
        Schema::create('asset_cameras', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: Sony A6000
        $table->string('type')->nullable(); // Sensor/DSLR/Mirrorless
        $table->string('status')->default('baik');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_cameras');
    }
};
