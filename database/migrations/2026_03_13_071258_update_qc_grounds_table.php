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
        Schema::table('qc_grounds', function (Blueprint $table) {
        // 1. Tambah Penanda Revisi
        $table->boolean('has_major_revision')->default(0)->after('project_id');

        // 2. Ubah struktur checklist lama menjadi 2 kolom (Kelengkapan & Kesesuaian)
        $items = ['form_log', 'raw_gps', 'report_gps', 'coordinate', 'photo_utsb'];
        
        foreach ($items as $item) {
            // Hapus kolom lama
            $table->dropColumn("chk_{$item}");
            
            // Tambah 2 kolom baru untuk QC Utama
            $table->boolean("chk_complete_{$item}")->default(0)->after('has_major_revision');
            $table->boolean("chk_folder_{$item}")->default(0)->after("chk_complete_{$item}");
            
            // Tambah 2 kolom baru & note untuk QC Revisi (Prefix: rev_)
            $table->boolean("rev_chk_complete_{$item}")->default(0);
            $table->boolean("rev_chk_folder_{$item}")->default(0);
            $table->string("rev_note_{$item}")->nullable();
        }

        // 3. Tambah kolom file untuk QC Revisi
        $table->string('rev_file_tolerance')->nullable();
        $table->string('rev_file_inacors')->nullable();
        $table->string('rev_file_google_earth')->nullable();

        // 4. Tambah petugas QC Revisi
        $table->date('rev_qc_date')->nullable();
        $table->string('rev_qc_officer_name')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
