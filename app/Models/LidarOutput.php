<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LidarOutput extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function hamparan()
    {
        return $this->belongsTo(LidarHamparan::class, 'lidar_hamparan_id');
    }
}
