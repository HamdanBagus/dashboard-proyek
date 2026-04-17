<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qc_uav_lidars', function (Blueprint $table) {
            // Notes untuk QC Utama
            $table->string('note_file_gap')->nullable();
            $table->string('note_file_accuracy')->nullable();

            // Notes untuk QC Revisi
            $table->string('rev_note_file_gap')->nullable();
            $table->string('rev_note_file_accuracy')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('qc_uav_lidars', function (Blueprint $table) {
            $table->dropColumn([
                'note_file_gap', 'note_file_accuracy',
                'rev_note_file_gap', 'rev_note_file_accuracy'
            ]);
        });
    }
};