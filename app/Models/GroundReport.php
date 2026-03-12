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
    // --- 1. Statistik Jumlah Titik ---
    public function getCountBmAttribute()
    {
        return $this->points()->where('point_type', 'BM')->count();
    }

    public function getCountIcpAttribute()
    {
        return $this->points()->where('point_type', 'ICP')->count();
    }

    public function getCountGcpAttribute()
    {
        return $this->points()->where('point_type', 'GCP')->count();
    }

    public function getTotalTitikAttribute()
    {
        return $this->points()->count();
    }

    // --- 2. Statistik Tahapan Selesai ---
    public function getInstalledCountAttribute()
    {
        return $this->points()->where('install_status', true)->count();
    }

    public function getMeasuredCountAttribute()
    {
        return $this->points()->where('measure_status', true)->count();
    }

    public function getProcessedCountAttribute()
    {
        return $this->points()->where('process_status', true)->count();
    }

    // --- 3. Persentase Keseluruhan (Overall Progress) ---
    public function getOverallProgressAttribute()
    {
        $total = $this->total_titik;
        if ($total === 0) return 0;

        $pctInstall = ($this->installed_count / $total) * 100;
        $pctMeasure = ($this->measured_count / $total) * 100;
        $pctProcess = ($this->processed_count / $total) * 100;

        return ($pctInstall + $pctMeasure + $pctProcess) / 3;
    }
}
