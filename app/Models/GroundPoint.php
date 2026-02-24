<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundPoint extends Model
{
    use HasFactory;

    // BARIS PENTING: Mengizinkan semua kolom diisi kecuali ID
    protected $guarded = ['id'];

    // Relasi balik ke Laporan Ground
    public function report()
    {
        return $this->belongsTo(GroundReport::class, 'ground_report_id');
    }
}
