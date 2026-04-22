<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService; 

class ProjectProgressController extends Controller
{
    public function index(Project $project)
    {
        // Eager Load all related data needed for progress calculation to avoid N+1 query problem in the views
        $project->load([
            'groundReport.points', 
            'uavReport.logs', 
            'photoReport.hamparans.outputs', 'photoReport.hamparans.progresses',
            'lidarReport.hamparans.outputs', 'lidarReport.hamparans.progresses'
        ]);

        // A. PROGRESS GROUND
        $groundProgress = 0;
        if ($project->groundReport) {
            $groundProgress = ProgressCalculatorService::calculateGroundProgress($project, $project->groundReport);
        }

        // B. PROGRESS UAV 
        $uavProgress = 0;
        if ($project->uavReport) {
            $uavData = ProgressCalculatorService::calculateUavProgress($project, $project->uavReport);
            $uavProgress = $uavData['persentase'];
        }

        // C. PROGRESS AIR PHOTO 
        $photoProgress = 0;
        if ($project->photoReport) {
            $photoProgress = ProgressCalculatorService::calculatePhotoReportOverallProgress($project->photoReport);
        }

        // D. PROGRESS LIDAR 
        $lidarProgress = 0;
        if ($project->lidarReport) {
            $lidarProgress = ProgressCalculatorService::calculateLidarReportOverallProgress($project->lidarReport);
        }

        // 3. LIMIT PROGRESS TO MAX 100% 
        $groundProgress = min($groundProgress, 100);
        $uavProgress    = min($uavProgress, 100);
        $photoProgress  = min($photoProgress, 100);
        $lidarProgress  = min($lidarProgress, 100);

        return view('projects.progress.index', compact(
            'project', 
            'groundProgress', 
            'uavProgress', 
            'photoProgress', 
            'lidarProgress'
        ));
    }
}