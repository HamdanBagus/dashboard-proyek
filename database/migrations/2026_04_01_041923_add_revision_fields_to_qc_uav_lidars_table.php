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
        Schema::table('qc_uav_lidars', function (Blueprint $table) {
            // Kolom Status Revisi
            $table->boolean('has_major_revision')->default(0)->after('file_accuracy');

            // Tambahan Checklist UTAMA (Kelengkapan & Folder)
            $items = ['raw_lidar', 'base_gps', 'pre_processing'];
            foreach ($items as $item) {
                $table->boolean("chk_complete_{$item}")->default(0);
                $table->boolean("chk_folder_{$item}")->default(0);
                
                // Checklist & Note REVISI
                $table->boolean("rev_chk_complete_{$item}")->default(0);
                $table->boolean("rev_chk_folder_{$item}")->default(0);
                $table->string("rev_note_{$item}")->nullable();
            }

            // File Pengecekan Kualitas REVISI
            $table->string('rev_file_gap')->nullable();
            $table->string('rev_file_accuracy')->nullable();

            // Footer REVISI
            $table->date('rev_qc_date')->nullable();
            $table->string('rev_qc_officer_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qc_uav_lidars', function (Blueprint $table) {
            $table->dropColumn(['has_major_revision', 'rev_file_gap', 'rev_file_accuracy', 'rev_qc_date', 'rev_qc_officer_name']);
            
            $items = ['raw_lidar', 'base_gps', 'pre_processing'];
            foreach ($items as $item) {
                $table->dropColumn(["chk_complete_{$item}", "chk_folder_{$item}", "rev_chk_complete_{$item}", "rev_chk_folder_{$item}", "rev_note_{$item}"]);
            }
        });
    }
};
