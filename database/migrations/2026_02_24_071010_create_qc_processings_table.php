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
        Schema::create('qc_processings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

        // Checklist Kelengkapan & Keterangan
        $table->boolean('chk_project_file')->default(0);
        $table->string('note_project_file')->nullable();

        $table->boolean('chk_ortho')->default(0);
        $table->string('note_ortho')->nullable();

        $table->boolean('chk_dsm')->default(0);
        $table->string('note_dsm')->nullable();

        $table->boolean('chk_dtm')->default(0);
        $table->string('note_dtm')->nullable();

        $table->boolean('chk_accuracy')->default(0);
        $table->string('note_accuracy')->nullable();

        $table->boolean('chk_report')->default(0);
        $table->string('note_report')->nullable();

        $table->boolean('chk_other')->default(0);
        $table->string('note_other')->nullable();

        // --- BUKTI FILE PENGECEK 1 (c1) ---
        $table->string('c1_file_accuracy')->nullable(); // CE90/LE90
        $table->string('c1_file_ortho')->nullable();    // Seamless
        $table->string('c1_file_cloud')->nullable();    // Noise & Spike
        $table->string('c1_file_folder')->nullable();   // Penamaan Folder
        $table->string('c1_file_hdd')->nullable();      // Foto Harddisk

        // --- BUKTI FILE PENGECEK 2 (c2) ---
        $table->string('c2_file_accuracy')->nullable();
        $table->string('c2_file_ortho')->nullable();
        $table->string('c2_file_cloud')->nullable();
        $table->string('c2_file_folder')->nullable();
        $table->string('c2_file_hdd')->nullable();

        // --- IDENTITAS PENGECEK 1 ---
        $table->date('c1_date')->nullable();
        $table->string('c1_name')->nullable();
        $table->enum('c1_revision', ['Y', 'N'])->nullable();

        // --- IDENTITAS PENGECEK 2 ---
        $table->date('c2_date')->nullable();
        $table->string('c2_name')->nullable();
        $table->enum('c2_revision', ['Y', 'N'])->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_processings');
    }
};
