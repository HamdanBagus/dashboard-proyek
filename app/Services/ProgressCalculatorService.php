<?php

namespace App\Services;

use App\Models\PhotoHamparan;
use App\Models\PhotoReport;
use App\Models\LidarHamparan; 
use App\Models\LidarReport;

class ProgressCalculatorService
{
    /**
     * Menghitung persentase gabungan (Tahapan + Output) untuk 1 Hamparan (Area) Spesifik.
     */
    public static function calculateHamparanProgress(PhotoHamparan $hamparan)
    {
        $pctTahapan = $hamparan->progress_percentage; // Memanggil accessor dari Model
        $pctOutput = $hamparan->output_percentage;    // Memanggil accessor dari Model
        $totalOutput = $hamparan->outputs()->count();

        // Jika belum ada output, nilai murni dari tahapan
        if ($totalOutput > 0) {
            return ($pctTahapan + $pctOutput) / 2;
        }

        return $pctTahapan;
    }

    /**
     * Menghitung rata-rata persentase keseluruhan (Overall) untuk 1 Project Laporan Foto.
     */
    public static function calculatePhotoReportOverallProgress(PhotoReport $report)
    {
        $hamparans = $report->hamparans;
        $count = $hamparans->count();

        if ($count === 0) return 0;

        $totalSemuaPersentase = 0;

        foreach ($hamparans as $h) {
            // Memanggil fungsi kalkulasi hamparan di atas untuk setiap area
            $totalSemuaPersentase += self::calculateHamparanProgress($h);
        }

        return $totalSemuaPersentase / $count;
    }
    public static function calculateLidarHamparanProgress(LidarHamparan $hamparan)
    {
        $pctTahapan = $hamparan->progress_percentage; 
        $pctOutput = $hamparan->output_percentage;    
        $totalOutput = $hamparan->outputs()->count();

        if ($totalOutput > 0) {
            return ($pctTahapan + $pctOutput) / 2;
        }

        return $pctTahapan;
    }

    /**
     * Menghitung rata-rata persentase keseluruhan (Overall) Laporan LiDAR.
     */
    public static function calculateLidarReportOverallProgress(LidarReport $report)
    {
        $hamparans = $report->hamparans;
        $count = $hamparans->count();

        if ($count === 0) return 0;

        $totalSemuaPersentase = 0;

        foreach ($hamparans as $h) {
            $totalSemuaPersentase += self::calculateLidarHamparanProgress($h);
        }

        return $totalSemuaPersentase / $count;
    }
    /**
     * Menghitung Performa Surveyor Tim Ground (Titik / Orang / Hari)
     */
    public static function calculateGroundSurveyorPerformance($project, $report) 
    {
        // A. Jumlah Surveyor
        $jumlahSurveyor = $project->personnel()->where('role', 'Surveyor')->count();

        // B. Jumlah Hari Kerja Lapangan (Rentang / Timespan)
        // Ambil semua tanggal pemasangan dan pengukuran yang tidak kosong
        $installDates = $report->points()->whereNotNull('install_date')->pluck('install_date');
        $measureDates = $report->points()->whereNotNull('measure_date')->pluck('measure_date');
        
        // Gabungkan kedua array tanggal tersebut
        $allDates = $installDates->merge($measureDates)->filter();

        $jumlahHari = 0;
        if ($allDates->isNotEmpty()) {
            // Cari tanggal paling awal dan paling akhir dari seluruh kumpulan data
            $startDate = \Carbon\Carbon::parse($allDates->min());
            $endDate = \Carbon\Carbon::parse($allDates->max());
            
            // Hitung selisih hari (+1 agar hari eksekusi di tanggal yang sama terhitung 1 hari)
            $jumlahHari = $startDate->diffInDays($endDate) + 1;
        }

        // C. Performa Harian
        $performa = 0;
        $totalTitik = $report->points()->count();

        if ($jumlahSurveyor > 0 && $jumlahHari > 0) {
            $performa = $totalTitik / $jumlahSurveyor / $jumlahHari;
        }

        return [
            'jumlah_surveyor' => $jumlahSurveyor,
            'jumlah_hari'     => $jumlahHari,
            'performa_harian' => $performa
        ];
    }
}