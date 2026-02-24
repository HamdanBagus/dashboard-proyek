<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- INI WAJIB ADA
use Illuminate\Database\Eloquent\Model;

class UavPilotLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Karyawan (Pilot)
    public function pilot()
    {
        return $this->belongsTo(Employee::class, 'pilot_id');
    }

    // Relasi ke Karyawan (Asisten)
    public function assistant()
    {
        return $this->belongsTo(Employee::class, 'assistant_id');
    }

    // Relasi ke Aset UAV
    public function uav()
    {
        return $this->belongsTo(AssetUav::class, 'uav_id');
    }
}
