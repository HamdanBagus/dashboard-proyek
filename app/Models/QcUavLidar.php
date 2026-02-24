<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcUavLidar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'uav_used' => 'array',
        'camera_used' => 'array',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
