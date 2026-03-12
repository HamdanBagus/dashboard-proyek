<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PhotoReport;
use App\Models\PhotoHamparan;
use App\Models\PhotoOutput;
use App\Models\PhotoProgress;
use App\Models\AssetPc; // Untuk dropdown PC
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService;

class PhotoReportController extends Controller
{
    /**
     * Halaman Utama Laporan Foto Udara (Header + List Hamparan + List Output)
     */
    public function index(Project $project)
    {
        $report = PhotoReport::firstOrCreate(
            ['project_id' => $project->id],
            ['status' => 'On Progress']
        );
        
        // Eager load relasi agar hemat query
        $hamparans = $report->hamparans()->with(['progresses', 'outputs'])->get();
        
        // Hitung persentase gabungan untuk masing-masing baris tabel
        foreach ($hamparans as $h) {
            $totalT = $h->progresses->count();
            $selesaiT = $h->progresses->where('status', 'Selesai')->count();
            $pctTahapan = $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;

            $totalO = $h->outputs->count();
            $selesaiO = $h->outputs->where('checklist', 1)->count();
            $pctOutput = $totalO > 0 ? ($selesaiO / $totalO) * 100 : 0;

            $h->persentase_gabungan = ($totalO > 0) ? (($pctTahapan + $pctOutput) / 2) : $pctTahapan;
        }

        // PANGGIL RUMUS DARI MODEL (Akan sama persis dengan Dashboard Utama)
        $pctOverall = $report->overall_progress;
        $hamparanCount = $hamparans->count();

        return view('projects.progress.photo.index', compact('project', 'report', 'hamparans', 'pctOverall', 'hamparanCount'));
    }

    /**
     * Update Header (Tanggal)
     */
    public function updateReport(Request $request, PhotoReport $report)
    {
        $report->update($request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]));
        return back()->with('success', 'Header laporan diperbarui.');
    }

    /**
     * Tambah Hamparan (Area)
     */
    public function storeHamparan(Request $request, PhotoReport $report)
    {
        $report->hamparans()->create($request->validate([
            'name' => 'required|string',
            'size' => 'required|numeric|min:0',
        ]));
        return back()->with('success', 'Hamparan berhasil ditambahkan.');
    }

    /**
     * Hapus Hamparan
     */
    public function destroyHamparan(PhotoHamparan $hamparan)
    {
        $hamparan->delete();
        return back()->with('success', 'Hamparan dihapus.');
    }

    /**
     * Tambah Output File
     */
    public function storeOutput(Request $request, PhotoHamparan $hamparan) // Ubah parameter menjadi PhotoHamparan
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

    /**
     * Hapus Output
     */
    public function destroyOutput(PhotoOutput $output)
    {
        $output->delete();
        return back()->with('success', 'Output dihapus.');
    }

    /**
     * Halaman Detail Hamparan (Tabel Progress Per Tahap)
     */
    public function showHamparan(PhotoHamparan $hamparan)
    {
        $project = $hamparan->photoReport->project;
        $pcs = AssetPc::all();
        $project->load('personnel');
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');
        $totalHariPengolahan = $hamparan->total_processing_days;

        // Statistik Angka Mentah (Untuk Badge)
        $totalTahapan = $hamparan->progresses()->count();
        $tahapanSelesai = $hamparan->progresses()->where('status', 'Selesai')->count();
        $totalOutput = $hamparan->outputs()->count();
        $outputSelesai = $hamparan->outputs()->where('checklist', 1)->count();
        
        // Panggil Rumus dari Service Class
        $persentase = ProgressCalculatorService::calculateHamparanProgress($hamparan);
        

        return view('projects.progress.photo.show_hamparan', compact(
            'hamparan', 'project', 'pcs', 'pengolahData',
            'totalTahapan', 'tahapanSelesai', 'totalOutput', 'outputSelesai', 'persentase','totalHariPengolahan'
        ));
    }

    /**
     * Tambah/Update Progress Tahapan
     */
    public function storeProgress(Request $request, PhotoHamparan $hamparan)
    {
        $request->validate(['stage_name' => 'required|string']);

        $hamparan->progresses()->create($request->all());
        return back()->with('success', 'Tahapan berhasil ditambahkan.');
    }

    /**
     * Hapus Progress Tahapan
     */
    public function destroyProgress(PhotoProgress $progress)
    {
        $progress->delete();
        return back()->with('success', 'Tahapan dihapus.');
    }
    // Fungsi untuk memperbarui data output dari pop-up modal
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
}
