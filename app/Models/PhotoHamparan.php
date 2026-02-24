<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi KE ATAS (Induk): Ke Laporan Foto
    public function photoReport()
    {
        return $this->belongsTo(PhotoReport::class);
    }

    // Relasi KE BAWAH (Anak): Ke Progress Tahapan
    public function progresses()
    {
        return $this->hasMany(PhotoProgress::class);
    }
}
