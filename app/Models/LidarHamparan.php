<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidarHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi KE ATAS (Induk): Ke Laporan LiDAR
    public function lidarReport() 
    { 
        return $this->belongsTo(LidarReport::class); 
    }
    
    // Relasi KE BAWAH (Anak): Ke Progress Tahapan
    public function progresses() 
    { 
        return $this->hasMany(LidarProgress::class); 
    }
    
    // Relasi KE BAWAH (Anak): Ke Output File
    public function outputs()
    {
        return $this->hasMany(LidarOutput::class, 'lidar_hamparan_id');
    }

    // Menghitung total hari proses dari semua tahapan
    public function getTotalProcessingDaysAttribute()
    {
        $minDate = $this->progresses()->whereNotNull('start_date')->min('start_date');
        $maxDate = $this->progresses()->whereNotNull('end_date')->max('end_date');

        if (!$minDate || !$maxDate) {
            return 0;
        }

        $start = \Carbon\Carbon::parse($minDate);
        $end = \Carbon\Carbon::parse($maxDate);

        return $start->diffInDays($end) + 1;
    }

    // =========================================================================
    // FUNGSI PERSENTASE DIHAPUS - Dipusatkan ke ProgressCalculatorService
    // =========================================================================
}