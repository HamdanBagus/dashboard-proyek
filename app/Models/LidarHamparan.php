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
        return $this->hasMany(LidarProgress::class)
        ->orderByRaw("
                CASE stage_name
                    WHEN 'Noise Removal' THEN 1
                    WHEN 'Auto Classification' THEN 2
                    WHEN 'Manual Classification' THEN 3
                    WHEN 'Manual Editing' THEN 4
                    WHEN 'Build DSM' THEN 5
                    WHEN 'Build DTM' THEN 6
                    WHEN 'Build Contour' THEN 7
                    WHEN 'Export Data' THEN 8
                    WHEN 'Uji Akurasi LE90' THEN 9     
                    ELSE 99 
                END ASC
            ")
            ->orderBy('id', 'asc'); 
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

}