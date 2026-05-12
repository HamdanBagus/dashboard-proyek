<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetUav extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    public function pic()
    {
        return $this->belongsTo(Employee::class, 'pic_id')->withTrashed();
    }
    public function maintenances()
    {
        return $this->hasMany(UavMaintenance::class, 'asset_uav_id');
    }
}
