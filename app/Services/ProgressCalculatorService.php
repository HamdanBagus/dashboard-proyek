<?php

namespace App\Services;

use App\Models\PhotoHamparan;
use App\Models\PhotoReport;
use App\Models\LidarHamparan; 
use App\Models\LidarReport;

class ProgressCalculatorService
{
    // count stages and outputs
    public static function getHamparanStats($hamparan)
    {
        $progresses = $hamparan->progresses;
        $outputs = $hamparan->outputs;

        // count unique stages for total and completed
        $totalTahapan = $progresses->map(function ($item) { 
            return strtolower(trim($item->stage_name)); 
        })->unique()->count();

        $tahapanSelesai = $progresses->where('status', 'Selesai')->map(function ($item) { 
            return strtolower(trim($item->stage_name)); 
        })->unique()->count();

        $pctTahapan = $totalTahapan > 0 ? ($tahapanSelesai / $totalTahapan) * 100 : 0;

        // count outputs for total and completed
        $totalOutput = $outputs->count();
        $outputSelesai = $outputs->where('checklist', 1)->count();
        
        $pctOutput = $totalOutput > 0 ? ($outputSelesai / $totalOutput) * 100 : 0;

        // merge progress and output percentages with equal weight
        $persentaseGabungan = $totalOutput > 0 ? ($pctTahapan + $pctOutput) / 2 : $pctTahapan;

        return [
            'total_tahapan'       => $totalTahapan,
            'tahapan_selesai'     => $tahapanSelesai,
            'pct_tahapan'         => $pctTahapan,
            'total_output'        => $totalOutput,
            'output_selesai'      => $outputSelesai,
            'pct_output'          => $pctOutput,
            'persentase_gabungan' => $persentaseGabungan
        ];
    }
    // count merge progress and output percentages for 1 Hamparan 
    public static function calculateHamparanProgress(PhotoHamparan $hamparan)
    {
        $stats = self::getHamparanStats($hamparan);
        return $stats['persentase_gabungan'];
    }

    // count merge progress and output percentages for 1 Hamparan LiDAR
    public static function calculateLidarHamparanProgress(LidarHamparan $hamparan)
    {
        $stats = self::getHamparanStats($hamparan);
        return $stats['persentase_gabungan'];
    }

    // count average overall progress for PhotoReport based on its Hamparans
    public static function calculatePhotoReportOverallProgress(PhotoReport $report)
    {
        $hamparans = $report->hamparans;
        $count = $hamparans->count();

        if ($count === 0) return 0;

        $totalSemuaPersentase = 0;
        foreach ($hamparans as $h) {
            $totalSemuaPersentase += self::calculateHamparanProgress($h);
        }

        return $totalSemuaPersentase / $count;
    }

    // count average overall progress for LidarReport based on its Hamparans
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

    // count surveyor performance based on jumlah surveyor, jumlah hari, dan total titik yang terpasang/terukur
    public static function calculateGroundSurveyorPerformance($project, $report) 
    {
        $jumlahSurveyor = $project->personnel()->where('role', 'Surveyor')->count();
        $installDates = $report->points()->whereNotNull('install_date')->pluck('install_date');
        $measureDates = $report->points()->whereNotNull('measure_date')->pluck('measure_date');
        $allDates = $installDates->merge($measureDates)->filter();

        $jumlahHari = 0;
        if ($allDates->isNotEmpty()) {
            $startDate = \Carbon\Carbon::parse($allDates->min());
            $endDate = \Carbon\Carbon::parse($allDates->max());
            $jumlahHari = $startDate->diffInDays($endDate) + 1;
        }

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

    // count uav progress
    public static function calculateUavProgress($project, $uavReport)
    {
        $luasTercapai = $uavReport->logs()->where('status', 'Finished Flight')->sum('area_acquired');
        $luasProyek = $project->area_size > 0 ? $project->area_size : 1;
        $persentase = ($luasTercapai / $luasProyek) * 100;

        return [
            'luas_tercapai' => $luasTercapai,
            'persentase'    => $persentase
        ];
    }

    // count uav pilot performance
    public static function calculateUavPilotSummary($uavReport)
    {
        $allLogs = $uavReport->logs;
        $groupedLogs = $allLogs->groupBy('pilot_id');
        $pilotStats = [];

        foreach ($groupedLogs as $pilotId => $logs) {
            $pilotName = $logs->first()->pilot->name ?? 'Pilot Tidak Diketahui';
            $totalArea = $logs->sum('area_acquired');
            $dates = $logs->pluck('date')->filter();
            
            $daysFlown = 0;
            if ($dates->isNotEmpty()) {
                $minDate = \Carbon\Carbon::parse($dates->min());
                $maxDate = \Carbon\Carbon::parse($dates->max());
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

        usort($pilotStats, function($a, $b) {
            return $b['total_area'] <=> $a['total_area'];
        });

        return $pilotStats;
    }
    // count overall progress for 1 Hamparan
    public static function calculateGroundProgress($project, $groundReport)
    {
        if (!$groundReport || $groundReport->points->count() === 0) {
            return 0;
        }

        $totalTitik = $groundReport->points->count();
        
        // count installed, measured, and processed points
        $installed  = $groundReport->points->where('install_status', true)->count();
        $measured   = $groundReport->points->where('measure_status', true)->count();
        $processed  = $groundReport->points->where('process_status', true)->count();

        $persentase = (( ($installed / $totalTitik) + ($measured / $totalTitik) + ($processed / $totalTitik) ) / 3) * 100;

        return min($persentase, 100); 
    }
}