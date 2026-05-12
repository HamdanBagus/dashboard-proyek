<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UavMaintenance extends Model
{
    use HasFactory;

    // Menggunakan guarded agar konsisten
    protected $guarded = ['id'];

    public function uav()
    {
        return $this->belongsTo(AssetUav::class, 'asset_uav_id');
    }
}