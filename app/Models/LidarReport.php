<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidarReport extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function project() { return $this->belongsTo(Project::class); }
    public function hamparans() { return $this->hasMany(LidarHamparan::class); }
    // public function outputs() { return $this->hasMany(LidarOutput::class); }

    /**
     * Hitung Persentase Keseluruhan Laporan LiDAR
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
