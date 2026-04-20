<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_uavs', function (Blueprint $table) {
            $table->string('serial_number')->nullable()->after('name');
            
            // Relasi ke tabel employees
            $table->foreignId('pic_id')->nullable()->constrained('employees')->nullOnDelete()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('asset_uavs', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropColumn(['serial_number', 'pic_id']);
        });
    }
};