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
        Schema::create('qc_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            // Checklist
            $table->boolean('chk_report')->default(0);
            $table->string('note_report')->nullable();

            $table->boolean('chk_other_docs')->default(0);
            $table->string('note_other_docs')->nullable();

            // Bukti File (Hanya 1 Pengecek)
            $table->string('file_report')->nullable();
            $table->string('file_other')->nullable();

            // Identitas Pengecek
            $table->date('qc_date')->nullable();
            $table->string('qc_name')->nullable();
            $table->enum('revision', ['Y', 'N'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_managers');
    }
};
