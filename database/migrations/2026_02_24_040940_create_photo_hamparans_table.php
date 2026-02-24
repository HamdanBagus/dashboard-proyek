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
        Schema::create('photo_hamparans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('photo_report_id')->constrained('photo_reports')->onDelete('cascade');

        $table->string('name'); // Nama Hamparan
        $table->double('size', 15, 2)->default(0); // Luas (Ha)

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_hamparans');
    }
};
