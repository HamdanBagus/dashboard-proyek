<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUav extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan insert data
    protected $guarded = ['id'];
}
