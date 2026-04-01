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
        Schema::table('qc_processings', function (Blueprint $table) {
            // 1. Hapus kolom pengecek ganda yang lama
            $table->dropColumn([
                'c1_file_accuracy', 'c1_file_ortho', 'c1_file_cloud', 'c1_file_folder', 'c1_file_hdd',
                'c2_file_accuracy', 'c2_file_ortho', 'c2_file_cloud', 'c2_file_folder', 'c2_file_hdd',
                'c1_date', 'c1_name', 'c1_revision',
                'c2_date', 'c2_name', 'c2_revision'
            ]);

            // 2. Tambah Status Revisi & Footer Utama
            $table->boolean('has_major_revision')->default(0)->after('note_other');
            $table->date('qc_date')->nullable();
            $table->string('qc_officer_name')->nullable();

            // 3. Tambah File Pengecekan UTAMA
            $table->string('file_accuracy')->nullable();
            $table->string('file_ortho')->nullable();
            $table->string('file_cloud')->nullable();
            $table->string('file_folder')->nullable();
            $table->string('file_hdd')->nullable();

            // 4. Tambah Checklist Folder Utama & Blok REVISI
            $items = ['project_file', 'ortho', 'dsm', 'dtm', 'accuracy', 'report', 'other'];
            foreach ($items as $item) {
                $table->boolean("chk_folder_{$item}")->default(0);
                
                // Blok Revisi
                $table->boolean("rev_chk_{$item}")->default(0);
                $table->boolean("rev_chk_folder_{$item}")->default(0);
                $table->string("rev_note_{$item}")->nullable();
            }

            // 5. Tambah File & Footer REVISI
            $table->string('rev_file_accuracy')->nullable();
            $table->string('rev_file_ortho')->nullable();
            $table->string('rev_file_cloud')->nullable();
            $table->string('rev_file_folder')->nullable();
            $table->string('rev_file_hdd')->nullable();
            
            $table->date('rev_qc_date')->nullable();
            $table->string('rev_qc_officer_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('standard', function (Blueprint $table) {
            //
        });
    }
};
