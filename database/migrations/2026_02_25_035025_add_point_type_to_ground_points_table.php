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
        Schema::table('ground_points', function (Blueprint $table) {
        // Menambahkan kolom point_type setelah kolom name
        $table->enum('point_type', ['BM', 'ICP', 'GCP', 'Lainnya'])->default('BM')->after('name');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ground_points', function (Blueprint $table) {
            //
        });
    }
};
