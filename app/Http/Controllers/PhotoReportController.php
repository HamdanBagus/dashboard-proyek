<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PhotoReport;
use App\Models\PhotoHamparan;
use App\Models\PhotoOutput;
use App\Models\PhotoProgress;
use App\Models\AssetPc; 
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService; // <-- Panggil Service Master Kita

class PhotoReportController extends Controller
{
    /**
     * Halaman Utama Laporan Foto Udara
     */
    public function index(Project $project)
    {
        $report = PhotoReport::firstOrCreate(
            ['project_id' => $project->id],
            ['status' => 'On Progress']
        );
        
        $hamparans = $report->hamparans()->with(['progresses', 'outputs'])->get();
        
        // Panggil Service untuk masing-masing baris tabel Hamparan
        foreach ($hamparans as $h) {
            $h->persentase_gabungan = ProgressCalculatorService::calculateHamparanProgress($h);
        }

        // Panggil Service untuk Total Keseluruhan Proyek
        $pctOverall = ProgressCalculatorService::calculatePhotoReportOverallProgress($report);
        $hamparanCount = $hamparans->count();

        return view('projects.progress.photo.index', compact('project', 'report', 'hamparans', 'pctOverall', 'hamparanCount'));
    }

    /**
     * Halaman Detail Hamparan (Tabel Progress Per Tahap)
     */
    public function showHamparan(PhotoHamparan $hamparan)
    {
        // 1. Eager Load Relasi
        $hamparan->load(['progresses', 'outputs', 'photoReport.project.personnel']);
        $project = $hamparan->photoReport->project;
        $pcs = AssetPc::all();
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');
        $totalHariPengolahan = $hamparan->total_processing_days;

        // =================================================================
        // 2. PANGGIL SINGLE SOURCE OF TRUTH (FUNGSI MASTER)
        // =================================================================
        $stats = ProgressCalculatorService::getHamparanStats($hamparan);
        
        // 3. Pecah array dari Service untuk dikirim ke Blade
        $totalTahapan = $stats['total_tahapan'];
        $tahapanSelesai = $stats['tahapan_selesai'];
        $totalOutput = $stats['total_output'];
        $outputSelesai = $stats['output_selesai'];
        $persentase = $stats['persentase_gabungan'];

        return view('projects.progress.photo.show_hamparan', compact(
            'hamparan', 'project', 'pcs', 'pengolahData',
            'totalTahapan', 'tahapanSelesai', 'totalOutput', 'outputSelesai', 'persentase','totalHariPengolahan'
        ));
    }

    // =========================================================================
    // FUNGSI CRUD LAINNYA TETAP SAMA (TIDAK ADA YANG BERUBAH)
    // =========================================================================

    public function updateReport(Request $request, PhotoReport $report) { /* ... */ }
    public function storeHamparan(Request $request, PhotoReport $report) { /* ... */ }
    public function destroyHamparan(PhotoHamparan $hamparan) { /* ... */ }
    public function storeOutput(Request $request, PhotoHamparan $hamparan) { /* ... */ }
    public function destroyOutput(PhotoOutput $output) { /* ... */ }
    public function storeProgress(Request $request, PhotoHamparan $hamparan) { /* ... */ }
    public function destroyProgress(PhotoProgress $progress) { /* ... */ }
    public function updateOutput(Request $request, PhotoOutput $output) { /* ... */ }
    public function updateProgress(Request $request, PhotoProgress $progress) { /* ... */ }
}