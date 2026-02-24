<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi (mass assignment)
    protected $guarded = ['id'];

    // Relasi: Satu Proyek memiliki banyak Personil (Karyawan)
    public function personnel()
    {
        // Menyambung ke model Employee lewat tabel pivot 'project_personnel'
        // withPivot('role') agar kita bisa akses kolom 'role' (PM, Pilot, dll)
        return $this->belongsToMany(Employee::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
