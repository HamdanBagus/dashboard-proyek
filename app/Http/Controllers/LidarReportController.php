<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\LidarReport;
use App\Models\LidarHamparan;
use App\Models\LidarOutput;
use App\Models\LidarProgress;
use App\Models\AssetPc;
use Illuminate\Http\Request;

class LidarReportController extends Controller
{
    public function index(Project $project)
    {
        $report = LidarReport::firstOrCreate(['project_id' => $project->id]);
        $hamparans = $report->hamparans;
        $outputs = $report->outputs;
        return view('projects.progress.lidar.index', compact('project', 'report', 'hamparans', 'outputs'));
    }

    public function updateReport(Request $request, LidarReport $report)
    {
        $report->update($request->validate(['start_date' => 'nullable|date', 'end_date' => 'nullable|date']));
        return back()->with('success', 'Header laporan diperbarui.');
    }

    public function storeHamparan(Request $request, LidarReport $report)
    {
        $report->hamparans()->create($request->validate(['name' => 'required', 'size' => 'required|numeric']));
        return back()->with('success', 'Hamparan ditambahkan.');
    }

    public function destroyHamparan(LidarHamparan $hamparan)
    {
        $hamparan->delete();
        return back()->with('success', 'Hamparan dihapus.');
    }

    public function showHamparan(LidarHamparan $hamparan)
    {
        $project = $hamparan->lidarReport->project;
        $pcs = AssetPc::all();
        // 2. Load data personil proyek tersebut
        $project->load('personnel');
        // 3. Filter khusus untuk role "Pengolah Data"
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');
        return view('projects.progress.lidar.show_hamparan', compact('hamparan', 'project', 'pcs','pengolahData'));
    }

    public function storeProgress(Request $request, LidarHamparan $hamparan)
    {
        $hamparan->progresses()->create($request->validate(['stage_name' => 'required']) + $request->all());
        return back()->with('success', 'Tahapan ditambahkan.');
    }

    public function destroyProgress(LidarProgress $progress)
    {
        $progress->delete();
        return back()->with('success', 'Tahapan dihapus.');
    }

    public function storeOutput(Request $request, LidarReport $report)
    {
        $report->outputs()->create($request->validate([
            'filename' => 'required', 'format' => 'required', 'checklist' => 'boolean'
        ]) + $request->all());
        return back()->with('success', 'Output ditambahkan.');
    }

    public function destroyOutput(LidarOutput $output)
    {
        $output->delete();
        return back()->with('success', 'Output dihapus.');
    }
}
