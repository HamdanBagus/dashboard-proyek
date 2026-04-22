<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UavReport;
use App\Models\UavPilotLog;
use App\Models\Employee;
use App\Models\AssetUav;
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService;

class UavReportController extends Controller
{
    public function index(Project $project)
    {
        // 1. search or create report for the project
        $report = UavReport::firstOrCreate(
            ['project_id' => $project->id]
        );

        $employees = Employee::all();
        $uavs = AssetUav::all();
        $uavData = ProgressCalculatorService::calculateUavProgress($project, $report);
        $luasTercapai = $uavData['luas_tercapai'];
        $persentase = $uavData['persentase'];

        return view('projects.progress.uav', compact(
            'project', 'report', 'employees', 'uavs','luasTercapai', 'persentase'
        ));
    }

    // update header report
    public function update(Request $request, UavReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $report->update($validated);
        return back()->with('success', 'Waktu pelaksanaan UAV berhasil diperbarui.');
    }

    // save log flight
    public function storeLog(Request $request, UavReport $report)
    {
        $validated = $request->validate([
            'date'          => 'required|date',
            'pilot_id'      => 'required',
            'assistant_id'  => 'nullable',
            'uav_id'        => 'required',
            'flight_count'  => 'required|numeric|min:0', 
            'area_acquired' => 'required|numeric|min:0', 
            'status'        => 'required|string', 
            'notes'         => 'nullable|string',
        ]);

        $report->logs()->create($validated);

        return redirect()->route('projects.uav.index', $report->project_id)
                         ->with('success', 'Log penerbangan berhasil ditambahkan.');
    }

    // update log flight
    public function updateLog(Request $request, UavPilotLog $log)
    {
        $validated = $request->validate([
            'date'          => 'required|date',
            'pilot_id'      => 'required',
            'assistant_id'  => 'nullable',
            'uav_id'        => 'required',
            'flight_count'  => 'required|numeric|min:0',
            'area_acquired' => 'required|numeric|min:0',
            'status'        => 'required|string',
            'notes'         => 'nullable|string',
        ]);

        $log->update($validated);

        $report = \App\Models\UavReport::find($log->uav_report_id);

        return redirect()->route('projects.uav.index', $report->project_id)
                         ->with('success', 'Log penerbangan berhasil diperbarui.');
    }

    // delete log flight
    public function destroyLog(UavPilotLog $log)
    {
        $report = \App\Models\UavReport::find($log->uav_report_id);
        $projectId = $report->project_id;
        
        $log->delete();
        
        return redirect()->route('projects.uav.index', $projectId)
                         ->with('success', 'Log penerbangan berhasil dihapus.');
    }

    // recap pilot
    public function pilotSummary(Project $project)
    {
        $report = \App\Models\UavReport::with(['logs.pilot', 'logs.uav', 'logs.assistant'])
                    ->where('project_id', $project->id)
                    ->firstOrFail();

        $pilotStats = ProgressCalculatorService::calculateUavPilotSummary($report);

        return view('projects.progress.uav_pilots', compact('project', 'pilotStats'));
    }
}