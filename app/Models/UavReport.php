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
    /**
     * Hitung total luas yang berhasil diakuisisi (Finished Flight)
     */
    public function getLuasTercapaiAttribute()
    {
        return $this->logs()->where('status', 'Finished Flight')->sum('area_acquired');
    }

    /**
     * Hitung Persentase Keseluruhan (Overall Progress UAV)
     */
    public function getOverallProgressAttribute()
    {
        // Ambil luas proyek dari relasi parent (Project)
        // Gunakan angka 1 jika kosong untuk mencegah error Division by Zero
        $luasProyek = optional($this->project)->area_size > 0 ? $this->project->area_size : 1;
        
        return ($this->luas_tercapai / $luasProyek) * 100;
    }
}
