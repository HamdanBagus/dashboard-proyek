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
        Schema::table('projects', function (Blueprint $table) {
        // Kolom List Teks (Bisa lebih dari 1) -> Menggunakan tipe JSON
        $table->json('products')->nullable()->after('status');
        $table->json('product_specs')->nullable()->after('products');
        $table->json('point_codes')->nullable()->after('product_specs');
        $table->json('tie_points')->nullable()->after('point_codes');

        // Kolom Angka (Integer)
        $table->integer('takeoff_count')->default(0)->after('tie_points');
        $table->integer('control_point_count')->default(0)->after('takeoff_count');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
