<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService; // Wajib panggil Service

class ProjectProgressController extends Controller
{
    public function index(Project $project)
    {
        // 1. Eager Load Relasi secara efisien untuk performa maksimal
        $project->load([
            'groundReport.points', 
            'uavReport.logs', 
            'photoReport.hamparans.outputs', 'photoReport.hamparans.progresses',
            'lidarReport.hamparans.outputs', 'lidarReport.hamparans.progresses'
        ]);

        // ==========================================
        // 2. HITUNG PROGRESS DARI SINGLE SOURCE OF TRUTH (SERVICE)
        // ==========================================

        // -- A. PROGRESS GROUND (Masih pakai hitungan manual karena Service Ground belum dibuat fungsi kembalian persentasenya) --
        $groundProgress = 0;
        if ($project->groundReport) {
            $groundProgress = ProgressCalculatorService::calculateGroundProgress($project, $project->groundReport);
        }

        // -- B. PROGRESS UAV --
        $uavProgress = 0;
        if ($project->uavReport) {
            // Panggil Service!
            $uavData = ProgressCalculatorService::calculateUavProgress($project, $project->uavReport);
            $uavProgress = $uavData['persentase'];
        }

        // -- C. PROGRESS FOTO UDARA --
        $photoProgress = 0;
        if ($project->photoReport) {
            // Panggil Service!
            $photoProgress = ProgressCalculatorService::calculatePhotoReportOverallProgress($project->photoReport);
        }

        // -- D. PROGRESS LIDAR --
        $lidarProgress = 0;
        if ($project->lidarReport) {
            // Panggil Service!
            $lidarProgress = ProgressCalculatorService::calculateLidarReportOverallProgress($project->lidarReport);
        }

        // 3. Batasi nilai maksimal 100% untuk mencegah anomali desain UI meluber
        $groundProgress = min($groundProgress, 100);
        $uavProgress    = min($uavProgress, 100);
        $photoProgress  = min($photoProgress, 100);
        $lidarProgress  = min($lidarProgress, 100);

        // 4. Kirim semua angka murni ke tampilan Blade
        return view('projects.progress.index', compact(
            'project', 
            'groundProgress', 
            'uavProgress', 
            'photoProgress', 
            'lidarProgress'
        ));
    }
}