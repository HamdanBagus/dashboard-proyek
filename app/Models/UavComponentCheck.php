<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UavComponentCheck extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function maintenanceLog() {
        return $this->belongsTo(UavMaintenanceLog::class, 'uav_maintenance_log_id');
    }
}