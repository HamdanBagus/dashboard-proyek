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
    /**
     * Menghitung Progress UAV (Luas Tercapai & Persentase)
     */
    public static function calculateUavProgress($project, $uavReport)
    {
        // Total luas yang sudah berstatus Finished Flight
        $luasTercapai = $uavReport->logs()->where('status', 'Finished Flight')->sum('area_acquired');
        
        // Mencegah pembagian dengan 0
        $luasProyek = $project->area_size > 0 ? $project->area_size : 1;

        $persentase = ($luasTercapai / $luasProyek) * 100;

        return [
            'luas_tercapai' => $luasTercapai,
            'persentase'    => $persentase
        ];
    }
    /**
     * Menghitung Rekapitulasi Performa Pilot UAV
     */
    public static function calculateUavPilotSummary($uavReport)
    {
        // 1. Ambil SEMUA log
        $allLogs = $uavReport->logs;

        // 2. Kelompokkan log berdasarkan ID pilot
        $groupedLogs = $allLogs->groupBy('pilot_id');

        $pilotStats = [];

        foreach ($groupedLogs as $pilotId => $logs) {
            $pilotName = $logs->first()->pilot->name ?? 'Pilot Tidak Diketahui';
            $totalArea = $logs->sum('area_acquired');
            
            // Ambil semua tanggal penerbangan dari log pilot ini dan filter yang tidak kosong
            $dates = $logs->pluck('date')->filter();
            
            $daysFlown = 0;
            if ($dates->isNotEmpty()) {
                // Cari tanggal paling awal dan paling akhir
                $minDate = \Carbon\Carbon::parse($dates->min());
                $maxDate = \Carbon\Carbon::parse($dates->max());
                
                // Hitung selisih hari (+1 agar hari eksekusi di tanggal yang sama terhitung 1 hari)
                // Dengan ini, hari jeda / weekend di antara min dan max akan tetap terhitung
                $daysFlown = $minDate->diffInDays($maxDate) + 1;
            }
            
            $averagePerDay = $daysFlown > 0 ? ($totalArea / $daysFlown) : 0;

            $pilotStats[] = [
                'name' => $pilotName,
                'total_area' => $totalArea,
                'days_flown' => $daysFlown,
                'average_per_day' => $averagePerDay,
                'flight_count' => $logs->sum('flight_count'),
                'logs' => $logs->sortByDesc('date') 
            ];
        }

        // 3. Urutkan berdasarkan total area terbanyak secara menurun (descending)
        usort($pilotStats, function($a, $b) {
            return $b['total_area'] <=> $a['total_area'];
        });

        return $pilotStats;
    }
}