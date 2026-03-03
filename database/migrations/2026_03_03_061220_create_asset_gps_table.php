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
        Schema::create('asset_gps', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Trimble R8s, Hi-Target V90
            $table->string('type')->nullable(); // Contoh: Geodetik Base, Geodetik Rover, Handheld
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_gps');
    }
};
