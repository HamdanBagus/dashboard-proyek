<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika error

class GroundReport extends Model
{
    // Izinkan semua kolom diisi
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke titik-titik (akan dipakai nanti)
    public function points()
    {
        return $this->hasMany(GroundPoint::class);
    }
}
