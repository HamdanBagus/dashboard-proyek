<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function personnel()
    {
        return $this->belongsToMany(Employee::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps()
                    ->withTrashed();
    }
    
    public function groundReport()
    {
        return $this->hasOne(GroundReport::class);
    }

    public function uavReport()
    {
        return $this->hasOne(UavReport::class);
    }

    public function photoReport()
    {
        return $this->hasOne(PhotoReport::class);
    }

    public function lidarReport()
    {
        return $this->hasOne(LidarReport::class);
    }
    protected $casts = [
        'products' => 'array',
        'product_specs' => 'array',
        'point_codes' => 'array',
        'tie_points' => 'array',
        'planned_uavs' => 'array',
        'planned_cameras' => 'array',
        'planned_gps' => 'array',
        'planned_pcs' => 'array',
    ];
    
}
