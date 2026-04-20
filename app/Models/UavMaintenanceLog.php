<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UavMaintenanceLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function uav() {
        return $this->belongsTo(AssetUav::class)->withTrashed(); // withTrashed penting!
    }

    public function componentChecks() {
        return $this->hasMany(UavComponentCheck::class);
    }
}