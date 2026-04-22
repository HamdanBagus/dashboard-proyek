<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_personnel')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}