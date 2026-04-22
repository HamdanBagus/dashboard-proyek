<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function photoReport()
    {
        return $this->belongsTo(PhotoReport::class);
    }

    public function progresses()
    {
        return $this->hasMany(PhotoProgress::class)
        ->orderByRaw("
                CASE stage_name
                    WHEN 'Align Photos' THEN 1
                    WHEN 'Marking GCP' THEN 2
                    WHEN 'Optimize Camera' THEN 3
                    WHEN 'Build Dense Cloud' THEN 4
                    WHEN 'Classify Ground Points' THEN 5
                    WHEN 'Build Mesh/Model' THEN 6
                    WHEN 'Smoothing Mesh/Model' THEN 7
                    WHEN 'Build DEM' THEN 8
                    WHEN 'Build Orthomosaic' THEN 9
                    WHEN 'Asign Images' THEN 10
                    WHEN 'Export Orthomosaic (TIF)' THEN 11
                    WHEN 'Export Orthomosaic (ECW)' THEN 12
                    WHEN 'Export DEM' THEN 13
                    WHEN 'Export Pointcloud' THEN 14
                    WHEN 'Ortho Rectifying' THEN 15
                    WHEN 'Tiling TIF' THEN 16
                    WHEN 'Tiling ECW' THEN 17
                    WHEN 'Tiling MBTiles' THEN 18
                    WHEN 'Tiling XYZ' THEN 19
                    WHEN 'Uji Akurasi CE90' THEN 20
                    WHEN 'Uji Akurasi LE90' THEN 21      
                    ELSE 99 
                END ASC
            ")
            ->orderBy('id', 'asc');
    }
    
    public function outputs()
    {
        return $this->hasMany(PhotoOutput::class, 'photo_hamparan_id');
    }

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