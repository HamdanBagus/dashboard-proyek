<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidarHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function lidarReport() 
    { 
        return $this->belongsTo(LidarReport::class); 
    }
    
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
    
    public function outputs()
    {
        return $this->hasMany(LidarOutput::class, 'lidar_hamparan_id');
    }

    // count total processing days based on progresses with valid start and end dates
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