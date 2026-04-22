<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GroundReport;
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService;

class GroundReportController extends Controller
{
    public function index(Project $project)
    {
        $report = GroundReport::firstOrCreate(
            ['project_id' => $project->id],
            [
                'bm_count' => 0,
                'icp_count' => 0,
                'gcp_count' => 0,
                'other_count' => 0
            ]
        );
        $report->load('points');
        
        // Load project personnel to calculate surveyor performance
        $project->load('personnel');
        $performaData = ProgressCalculatorService::calculateGroundSurveyorPerformance($project, $report);

        return view('projects.progress.ground', compact('project', 'report', 'performaData'));
    }
    // Update Ground Report 
    public function update(Request $request, GroundReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'coordinator_name' => 'nullable|string|max:255',
        ]);

        $report->update($validated);

        return back()->with('success', 'Informasi pelaksanaan berhasil diperbarui!');
    }
}
