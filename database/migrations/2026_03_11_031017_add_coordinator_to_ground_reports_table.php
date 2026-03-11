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
        Schema::table('ground_reports', function (Blueprint $table) {
        $table->string('coordinator_name')->nullable()->after('end_date');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ground_reports', function (Blueprint $table) {
        $table->dropColumn('coordinator_name');
    });
    }
};
