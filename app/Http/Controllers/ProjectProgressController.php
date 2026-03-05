<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GroundReport;
use App\Models\UavReport;
use App\Models\PhotoReport;
use App\Models\LidarReport;
use Illuminate\Http\Request;

class ProjectProgressController extends Controller
{
    public function index(Project $project)
    {
        // 1. HITUNG PROGRESS GROUND
        $groundProgress = 0;
        $groundReport = GroundReport::with('points')->where('project_id', $project->id)->first();
        if ($groundReport && $groundReport->points->count() > 0) {
            $totalTitik = $groundReport->points->count();
            $installed = $groundReport->points->where('install_status', true)->count();
            $measured = $groundReport->points->where('measure_status', true)->count();
            $processed = $groundReport->points->where('process_status', true)->count();

            $groundProgress = (( ($installed/$totalTitik) + ($measured/$totalTitik) + ($processed/$totalTitik) ) / 3) * 100;
        }

        // 2. HITUNG PROGRESS UAV
        $uavProgress = 0;
        $uavReport = UavReport::with('logs')->where('project_id', $project->id)->first();
        if ($uavReport && $project->area_size > 0) {
            $luasTercapai = $uavReport->logs->where('status', 'Finished Flight')->sum('area_acquired');
            $uavProgress = ($luasTercapai / $project->area_size) * 100;
        }

        // 3. HITUNG PROGRESS FOTO UDARA
        $photoProgress = 0;
        $photoReport = PhotoReport::with(['hamparans.progresses', 'outputs'])->where('project_id', $project->id)->first();
        if ($photoReport) {
            // Rata-rata Hamparan
            $hamparanProgress = 0;
            $hamparanCount = $photoReport->hamparans->count();
            foreach($photoReport->hamparans as $h) {
                $totalT = $h->progresses->count();
                $selesaiT = $h->progresses->where('status', 'Selesai')->count();
                $hamparanProgress += $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;
            }
            $pctPengolahanFoto = $hamparanCount > 0 ? ($hamparanProgress / $hamparanCount) : 0;

            // Rata-rata Output
            $totalOut = $photoReport->outputs->count();
            $selesaiOut = $photoReport->outputs->where('checklist', 1)->count();
            $pctOutputFoto = $totalOut > 0 ? ($selesaiOut / $totalOut) * 100 : 0;

            $photoProgress = ($pctPengolahanFoto + $pctOutputFoto) / 2;
        }

        // 4. HITUNG PROGRESS LIDAR
        $lidarProgress = 0;
        $lidarReport = LidarReport::with(['hamparans.progresses', 'outputs'])->where('project_id', $project->id)->first();
        if ($lidarReport) {
            // Rata-rata Hamparan
            $hamparanProgress = 0;
            $hamparanCount = $lidarReport->hamparans->count();
            foreach($lidarReport->hamparans as $h) {
                $totalT = $h->progresses->count();
                $selesaiT = $h->progresses->where('status', 'Selesai')->count();
                $hamparanProgress += $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;
            }
            $pctPengolahanLidar = $hamparanCount > 0 ? ($hamparanProgress / $hamparanCount) : 0;

            // Rata-rata Output
            $totalOut = $lidarReport->outputs->count();
            $selesaiOut = $lidarReport->outputs->where('checklist', 1)->count();
            $pctOutputLidar = $totalOut > 0 ? ($selesaiOut / $totalOut) * 100 : 0;

            $lidarProgress = ($pctPengolahanLidar + $pctOutputLidar) / 2;
        }

        // Batasi nilai maksimal 100%
        $groundProgress = min($groundProgress, 100);
        $uavProgress = min($uavProgress, 100);
        $photoProgress = min($photoProgress, 100);
        $lidarProgress = min($lidarProgress, 100);

        // Kirim semua variabel ke tampilan
        return view('projects.progress.index', compact(
            'project', 
            'groundProgress', 
            'uavProgress', 
            'photoProgress', 
            'lidarProgress'
        ));
    }
}