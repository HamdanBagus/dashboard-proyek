<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // RELASI BARU: 1 Karyawan (bisa jadi) punya 1 Akun Login
    public function user()
    {
        return $this->hasOne(User::class);
    }
}