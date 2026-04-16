<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qc_grounds', function (Blueprint $table) {
            // 1. Tambah File ke-4 (UTSB)
            $table->string('file_utsb')->nullable();
            $table->string('rev_file_utsb')->nullable();

            // 2. Tambah Notes untuk ke-4 file di QC Utama
            $table->string('note_file_tolerance')->nullable();
            $table->string('note_file_inacors')->nullable();
            $table->string('note_file_google_earth')->nullable();
            $table->string('note_file_utsb')->nullable();

            // 3. Tambah Notes untuk ke-4 file di QC Revisi
            $table->string('rev_note_file_tolerance')->nullable();
            $table->string('rev_note_file_inacors')->nullable();
            $table->string('rev_note_file_google_earth')->nullable();
            $table->string('rev_note_file_utsb')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('qc_grounds', function (Blueprint $table) {
            $table->dropColumn([
                'file_utsb', 'rev_file_utsb',
                'note_file_tolerance', 'note_file_inacors', 'note_file_google_earth', 'note_file_utsb',
                'rev_note_file_tolerance', 'rev_note_file_inacors', 'rev_note_file_google_earth', 'rev_note_file_utsb'
            ]);
        });
    }
};