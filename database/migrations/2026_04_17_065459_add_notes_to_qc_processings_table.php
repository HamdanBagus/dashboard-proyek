<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qc_processings', function (Blueprint $table) {
            // Notes untuk QC Utama
            $table->string('note_file_accuracy')->nullable();
            $table->string('note_file_ortho')->nullable();
            $table->string('note_file_cloud')->nullable();
            $table->string('note_file_folder')->nullable();
            $table->string('note_file_hdd')->nullable();

            // Notes untuk QC Revisi
            $table->string('rev_note_file_accuracy')->nullable();
            $table->string('rev_note_file_ortho')->nullable();
            $table->string('rev_note_file_cloud')->nullable();
            $table->string('rev_note_file_folder')->nullable();
            $table->string('rev_note_file_hdd')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('qc_processings', function (Blueprint $table) {
            $table->dropColumn([
                'note_file_accuracy', 'note_file_ortho', 'note_file_cloud', 'note_file_folder', 'note_file_hdd',
                'rev_note_file_accuracy', 'rev_note_file_ortho', 'rev_note_file_cloud', 'rev_note_file_folder', 'rev_note_file_hdd'
            ]);
        });
    }
};