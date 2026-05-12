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
        Schema::create('uav_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_uav_id')->constrained('asset_uavs')->cascadeOnDelete();
            $table->integer('kilometer')->nullable();
            $table->string('service_location')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('return_date')->nullable();
            $table->text('issue_notes')->nullable();
            $table->text('replaced_parts')->nullable();
            $table->string('documentation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uav_maintenances');
    }
};
