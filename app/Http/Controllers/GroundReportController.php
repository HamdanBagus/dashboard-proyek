<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GroundReport;
use Illuminate\Http\Request;
use App\Services\ProgressCalculatorService;

class GroundReportController extends Controller
{
    /**
     * Menampilkan Halaman Laporan Ground
     */
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
        
        // Load data personil yang ada di proyek ini
        $project->load('personnel');
        // Panggil Service untuk Kalkulasi Performa
        $performaData = ProgressCalculatorService::calculateGroundSurveyorPerformance($project, $report);

        return view('projects.progress.ground', compact('project', 'report', 'performaData'));
    }

    /**
     * Update Data Header (Tanggal & Jumlah Titik)
     */
    public function update(Request $request, GroundReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            // Tambahkan validasi untuk nama koordinator
            'coordinator_name' => 'nullable|string|max:255',
        ]);

        $report->update($validated);

        return back()->with('success', 'Informasi pelaksanaan berhasil diperbarui!');
    }
}
