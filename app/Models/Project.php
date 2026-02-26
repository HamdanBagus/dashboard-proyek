<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi (mass assignment)
    protected $guarded = ['id'];

    // Relasi: Satu Proyek memiliki banyak Personil (Karyawan)
    public function personnel()
    {
        // Menyambung ke model Employee lewat tabel pivot 'project_personnel'
        // withPivot('role') agar kita bisa akses kolom 'role' (PM, Pilot, dll)
        return $this->belongsToMany(Employee::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps();
    }
    // Relasi ke Laporan Tim Ground (HasOne karena 1 proyek = 1 laporan utama)
    public function groundReport()
    {
        return $this->hasOne(GroundReport::class);
    }

    // Relasi ke Laporan Tim UAV
    public function uavReport()
    {
        return $this->hasOne(UavReport::class);
    }

    // Relasi ke Laporan Pengolahan Foto Udara
    public function photoReport()
    {
        return $this->hasOne(PhotoReport::class);
    }

    // Relasi ke Laporan Pengolahan LiDAR
    public function lidarReport()
    {
        return $this->hasOne(LidarReport::class);
    }
    protected $casts = [
        'products' => 'array',
        'product_specs' => 'array',
        'point_codes' => 'array',
        'tie_points' => 'array',
    ];
}
