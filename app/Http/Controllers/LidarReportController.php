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
        $report->update($request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]));
        return back()->with('success', 'Header laporan diperbarui.');
    }

    public function storeHamparan(Request $request, LidarReport $report)
    {
        $report->hamparans()->create($request->validate([
            'name' => 'required',
            'size' => 'required|numeric'
        ]));
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
        // Load data personil proyek tersebut
        $project->load('personnel');
        // Filter khusus untuk role "Pengolah Data"
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');

        return view('projects.progress.lidar.show_hamparan', compact('hamparan', 'project', 'pcs', 'pengolahData'));
    }

    // --- PROGRESS TAHAPAN ---

    public function storeProgress(Request $request, LidarHamparan $hamparan)
    {
        $hamparan->progresses()->create($request->validate([
            'stage_name' => 'required|string|max:255',
            'status' => 'nullable|string'
        ]) + $request->all());

        return back()->with('success', 'Tahapan ditambahkan.');
    }

    // FUNGSI BARU: Untuk Modal Update Tahapan Progress (Jika ada)
    public function updateProgress(Request $request, LidarProgress $progress)
    {
        $validated = $request->validate([
            'stage_name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string',
            'processor_name' => 'nullable|string',
            'pc_name' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $progress->update($validated);

        return back()->with('success', 'Progress tahapan berhasil diperbarui!');
    }

    public function destroyProgress(LidarProgress $progress)
    {
        $progress->delete();
        return back()->with('success', 'Tahapan dihapus.');
    }


    // --- OUTPUT PRODUK ---

    public function storeOutput(Request $request, LidarReport $report)
    {
        // Validasi disesuaikan agar bisa menerima input bebas (datalist)
        $validated = $request->validate([
            'filename' => 'required|string|max:255',
            'format' => 'required|string|max:255',
            'checklist' => 'required|boolean'
        ]);

        $report->outputs()->create($validated);

        return back()->with('success', 'Output berhasil didaftarkan.');
    }

    // FUNGSI BARU: Untuk Modal Update Output
    public function updateOutput(Request $request, LidarOutput $output)
    {
        $validated = $request->validate([
            'filename' => 'required|string|max:255',
            'format' => 'required|string|max:255',
            'size_gb' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:1000',
            'checklist' => 'required|boolean',
        ]);

        $output->update($validated);

        return back()->with('success', 'Detail output berhasil diperbarui!');
    }

    public function destroyOutput(LidarOutput $output)
    {
        $output->delete();
        return back()->with('success', 'Output dihapus.');
    }
}
