<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoHamparan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi KE ATAS (Induk): Ke Laporan Foto
    public function photoReport()
    {
        return $this->belongsTo(PhotoReport::class);
    }

    // Relasi KE BAWAH (Anak): Ke Progress Tahapan
    public function progresses()
    {
        return $this->hasMany(PhotoProgress::class);
    }
    public function outputs()
    {
        return $this->hasMany(PhotoOutput::class, 'photo_hamparan_id');
    }
    // perhitugan total hari proses dari semua tahapan (start_date paling awal sampai end_date paling akhir)
    public function getTotalProcessingDaysAttribute()
    {
        // Cari tanggal start_date terkecil (paling awal) di semua tahapan
        $minDate = $this->progresses()->whereNotNull('start_date')->min('start_date');
        
        // Cari tanggal end_date terbesar (paling akhir) di semua tahapan
        $maxDate = $this->progresses()->whereNotNull('end_date')->max('end_date');

        // Jika salah satu atau kedua tanggal kosong, kembalikan 0
        if (!$minDate || !$maxDate) {
            return 0;
        }

        // Ubah string tanggal menjadi objek Carbon untuk menghitung selisih
        $start = \Carbon\Carbon::parse($minDate);
        $end = \Carbon\Carbon::parse($maxDate);

        // Jika start dan end di hari yang sama, dihitung 1 hari. 
        // Jadi kita tambahkan +1 pada selisihnya (diffInDays).
        return $start->diffInDays($end) + 1;
    }
    // --- 1. Hitung Persentase Tahapan (Hanya dari tabel progresses) ---
    public function getProgressPercentageAttribute()
    {
        $total = $this->progresses()->count();
        if ($total === 0) return 0;
        
        $selesai = $this->progresses()->where('status', 'Selesai')->count();
        return ($selesai / $total) * 100;
    }

    // --- 2. Hitung Persentase Output (Hanya dari tabel outputs) ---
    public function getOutputPercentageAttribute()
    {
        $total = $this->outputs()->count();
        if ($total === 0) return 0;

        $selesai = $this->outputs()->where('checklist', 1)->count();
        return ($selesai / $total) * 100;
    }
}
