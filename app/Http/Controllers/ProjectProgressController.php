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
        
        // PERBAIKAN 1: Ubah 'outputs' menjadi 'hamparans.outputs'
        $photoReport = \App\Models\PhotoReport::with(['hamparans.progresses', 'hamparans.outputs'])->where('project_id', $project->id)->first();
        
        if ($photoReport) {
            $hamparanProgress = 0;
            $hamparanCount = $photoReport->hamparans->count();
            
            // Siapkan wadah untuk menampung jumlah output dari seluruh hamparan
            $totalOut = 0;
            $selesaiOut = 0;

            foreach($photoReport->hamparans as $h) {
                // A. Hitung Progress Tahapan per Hamparan
                $totalT = $h->progresses->count();
                $selesaiT = $h->progresses->where('status', 'Selesai')->count();
                $hamparanProgress += $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;

                // B. PERBAIKAN 2: Hitung Progress Output dari DALAM Hamparan
                $totalOut += $h->outputs->count();
                $selesaiOut += $h->outputs->where('checklist', 1)->count();
            }
            
            // Persentase Tahapan (Rata-rata dari semua area)
            $pctPengolahanFoto = $hamparanCount > 0 ? ($hamparanProgress / $hamparanCount) : 0;

            // Persentase Output (Gabungan dari semua output di semua area)
            $pctOutputFoto = $totalOut > 0 ? ($selesaiOut / $totalOut) * 100 : 0;

            // PERBAIKAN 3: Logika pembagian adil
            // Jika belum ada output sama sekali yang didaftarkan, nilai diambil 100% dari pengolahan
            if ($totalOut > 0) {
                $photoProgress = ($pctPengolahanFoto + $pctOutputFoto) / 2;
            } else {
                $photoProgress = $pctPengolahanFoto;
            }
        }

        // 4. HITUNG PROGRESS LIDAR
        $lidarReport = \App\Models\LidarReport::with(['hamparans.progresses', 'hamparans.outputs'])->where('project_id', $project->id)->first();
        $lidarProgress = $lidarReport ? $lidarReport->overall_progress : 0;

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