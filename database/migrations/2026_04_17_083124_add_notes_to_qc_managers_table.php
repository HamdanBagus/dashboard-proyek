<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qc_managers', function (Blueprint $table) {
            // Notes untuk QC Utama
            $table->string('note_file_report')->nullable();
            $table->string('note_file_other')->nullable();

            // Notes untuk QC Revisi
            $table->string('rev_note_file_report')->nullable();
            $table->string('rev_note_file_other')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('qc_managers', function (Blueprint $table) {
            $table->dropColumn([
                'note_file_report', 'note_file_other',
                'rev_note_file_report', 'rev_note_file_other'
            ]);
        });
    }
};