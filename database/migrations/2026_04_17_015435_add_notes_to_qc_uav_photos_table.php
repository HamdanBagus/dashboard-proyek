<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qc_uav_photos', function (Blueprint $table) {
            // Notes untuk QC Utama
            $table->string('note_file_quality')->nullable();
            $table->string('note_file_geotag')->nullable();
            $table->string('note_file_blur')->nullable();
            $table->string('note_file_overlap')->nullable();
            $table->string('note_file_gsd')->nullable();

            // Notes untuk QC Revisi
            $table->string('rev_note_file_quality')->nullable();
            $table->string('rev_note_file_geotag')->nullable();
            $table->string('rev_note_file_blur')->nullable();
            $table->string('rev_note_file_overlap')->nullable();
            $table->string('rev_note_file_gsd')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('qc_uav_photos', function (Blueprint $table) {
            $table->dropColumn([
                'note_file_quality', 'note_file_geotag', 'note_file_blur', 'note_file_overlap', 'note_file_gsd',
                'rev_note_file_quality', 'rev_note_file_geotag', 'rev_note_file_blur', 'rev_note_file_overlap', 'rev_note_file_gsd'
            ]);
        });
    }
};