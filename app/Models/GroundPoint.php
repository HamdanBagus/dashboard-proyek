<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundPoint extends Model
{
    use HasFactory;

    // allow mass assignment except for 'id'
    protected $guarded = ['id'];

    // relation to GroundReport
    public function report()
    {
        return $this->belongsTo(GroundReport::class, 'ground_report_id');
    }
}
