<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PhotoReport;
use App\Models\PhotoHamparan;
use App\Models\PhotoOutput;
use App\Models\PhotoProgress;
use App\Models\AssetPc; 
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService; 

class PhotoReportController extends Controller
{
    public function index(Project $project)
    {
        $report = PhotoReport::firstOrCreate(
            ['project_id' => $project->id],
            ['status' => 'On Progress']
        );
        
        $hamparans = $report->hamparans()->with(['progresses', 'outputs'])->get();
        
        foreach ($hamparans as $h) {
            $h->persentase_gabungan = ProgressCalculatorService::calculateHamparanProgress($h);
        }

        $pctOverall = ProgressCalculatorService::calculatePhotoReportOverallProgress($report);
        $hamparanCount = $hamparans->count();

        return view('projects.progress.photo.index', compact('project', 'report', 'hamparans', 'pctOverall', 'hamparanCount'));
    }

    // update header
    public function updateReport(Request $request, PhotoReport $report)
    {
        $report->update($request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]));
        return back()->with('success', 'Header laporan diperbarui.');
    }

    // add new hamparan
    public function storeHamparan(Request $request, PhotoReport $report)
    {
        $report->hamparans()->create($request->validate([
            'name' => 'required|string',
            'size' => 'required|numeric|min:0',
        ]));
        return back()->with('success', 'Hamparan berhasil ditambahkan.');
    }

    //delete hamparan
    public function destroyHamparan(PhotoHamparan $hamparan)
    {
        $hamparan->delete();
        return back()->with('success', 'Hamparan dihapus.');
    }

    // add new output
    public function storeOutput(Request $request, PhotoHamparan $hamparan) 
    {
        $hamparan->outputs()->create($request->validate([
            'filename' => 'required|string', 
            'format' => 'required|string',   
            'size_gb' => 'nullable|numeric',
            'location' => 'nullable|string',
            'checklist' => 'boolean', 
        ]));
        
        return back()->with('success', 'Output berhasil ditambahkan ke area ini.');
    }

    // delete output
    public function destroyOutput(PhotoOutput $output)
    {
        $output->delete();
        return back()->with('success', 'Output dihapus.');
    }

    //update output
    public function updateOutput(Request $request, PhotoOutput $output)
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

    // Show detail hamparan
    public function showHamparan(PhotoHamparan $hamparan)
    {
        $hamparan->load(['progresses', 'outputs', 'photoReport.project.personnel']);
        $project = $hamparan->photoReport->project;
        $pcs = AssetPc::all();
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');
        $totalHariPengolahan = $hamparan->total_processing_days;

        $stats = ProgressCalculatorService::getHamparanStats($hamparan);
        
        $totalTahapan = $stats['total_tahapan'];
        $tahapanSelesai = $stats['tahapan_selesai'];
        $totalOutput = $stats['total_output'];
        $outputSelesai = $stats['output_selesai'];
        $persentase = $stats['persentase_gabungan'];

        return view('projects.progress.photo.show_hamparan', compact(
            'hamparan', 'project', 'pcs', 'pengolahData',
            'totalTahapan', 'tahapanSelesai', 'totalOutput', 'outputSelesai', 'persentase','totalHariPengolahan',
        ));
    }
    //add new progress 
    public function storeProgress(Request $request, PhotoHamparan $hamparan)
    {
        $request->validate(['stage_name' => 'required|string']);

        $hamparan->progresses()->create($request->all());
        return back()->with('success', 'Tahapan berhasil ditambahkan.');
    }

    //update progress
    public function updateProgress(Request $request, PhotoProgress $progress)
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

    //delete progress
    public function destroyProgress(PhotoProgress $progress)
    {
        $progress->delete();
        return back()->with('success', 'Tahapan dihapus.');
    }
}