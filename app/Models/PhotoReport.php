<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoReport extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi KE ATAS: Ke Proyek Utama
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi KE BAWAH: Ke Hamparan & Output
    public function hamparans()
    {
        return $this->hasMany(PhotoHamparan::class);
    }

    public function outputs()
    {
        return $this->hasMany(PhotoOutput::class);
    }
}
