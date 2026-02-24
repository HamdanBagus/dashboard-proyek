<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi balik: Satu Karyawan bisa ada di banyak Proyek
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
