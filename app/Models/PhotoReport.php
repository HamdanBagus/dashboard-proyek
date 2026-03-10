<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoReport extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi KE ATAS: Ke Proyek Utama
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi KE BAWAH: Ke Hamparan & Output
    public function hamparans()
    {
        return $this->hasMany(PhotoHamparan::class);
    }

    public function outputs()
    {
        return $this->hasMany(PhotoOutput::class);
    }
    /**
     * Hitung Persentase Keseluruhan Laporan Foto Udara
     */
    public function getOverallProgressAttribute()
    {
        $hamparans = $this->hamparans; 
        $hamparanCount = $hamparans->count();
        
        if ($hamparanCount === 0) return 0;

        $totalSemuaPersentase = 0;

        foreach ($hamparans as $h) {
            // Progress Tahapan
            $totalT = $h->progresses->count();
            $selesaiT = $h->progresses->where('status', 'Selesai')->count();
            $pctTahapan = $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;

            // Progress Output
            $totalO = $h->outputs->count();
            $selesaiO = $h->outputs->where('checklist', 1)->count();
            $pctOutput = $totalO > 0 ? ($selesaiO / $totalO) * 100 : 0;

            // Gabungan Area
            $pctGabungan = ($totalO > 0) ? (($pctTahapan + $pctOutput) / 2) : $pctTahapan;
            $totalSemuaPersentase += $pctGabungan;
        }

        return $totalSemuaPersentase / $hamparanCount;
    }
}
