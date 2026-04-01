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
        Schema::table('qc_managers', function (Blueprint $table) {
            // Ubah tipe revisi lama dan tambahkan standard baru
            $table->boolean('has_major_revision')->default(0)->after('file_other');
            
            // Tambahkan checklist folder untuk UTAMA
            $table->boolean('chk_folder_report')->default(0)->after('chk_report');
            $table->boolean('chk_folder_other_docs')->default(0)->after('chk_other_docs');

            // Tambahkan blok REVISI untuk Report
            $table->boolean('rev_chk_report')->default(0);
            $table->boolean('rev_chk_folder_report')->default(0);
            $table->string('rev_note_report')->nullable();
            
            // Tambahkan blok REVISI untuk Dokumen Lain
            $table->boolean('rev_chk_other_docs')->default(0);
            $table->boolean('rev_chk_folder_other_docs')->default(0);
            $table->string('rev_note_other_docs')->nullable();

            // File Bukti REVISI
            $table->string('rev_file_report')->nullable();
            $table->string('rev_file_other')->nullable();

            // Footer REVISI
            $table->date('rev_qc_date')->nullable();
            $table->string('rev_qc_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qc_managers', function (Blueprint $table) {
            $table->dropColumn([
                'has_major_revision', 'chk_folder_report', 'chk_folder_other_docs',
                'rev_chk_report', 'rev_chk_folder_report', 'rev_note_report',
                'rev_chk_other_docs', 'rev_chk_folder_other_docs', 'rev_note_other_docs',
                'rev_file_report', 'rev_file_other', 'rev_qc_date', 'rev_qc_name'
            ]);
        });
    }
};
