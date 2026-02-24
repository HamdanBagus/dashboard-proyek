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
    public function outputs() { return $this->hasMany(LidarOutput::class); }
}
