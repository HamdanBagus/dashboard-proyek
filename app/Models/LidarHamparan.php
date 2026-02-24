<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidarHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function lidarReport() { return $this->belongsTo(LidarReport::class); }
    public function progresses() { return $this->hasMany(LidarProgress::class); }
}
