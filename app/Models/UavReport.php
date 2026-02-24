<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- INI WAJIB ADA
use Illuminate\Database\Eloquent\Model;

class UavReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logs()
    {
        return $this->hasMany(UavPilotLog::class);
    }
}
