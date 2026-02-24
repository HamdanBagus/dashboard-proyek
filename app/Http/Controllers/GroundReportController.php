<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GroundReport;
use Illuminate\Http\Request;

class GroundReportController extends Controller
{
    /**
     * Menampilkan Halaman Laporan Ground
     */
    public function index(Project $project)
    {
        // Cari laporan ground milik proyek ini, atau buat baru jika belum ada
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

        return view('projects.progress.ground', compact('project', 'report'));
    }

    /**
     * Update Data Header (Tanggal & Jumlah Titik)
     */
    public function update(Request $request, GroundReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'bm_count' => 'required|integer|min:0',
            'icp_count' => 'required|integer|min:0',
            'gcp_count' => 'required|integer|min:0',
            'other_count' => 'required|integer|min:0',
        ]);

        $report->update($validated);

        return back()->with('success', 'Data laporan berhasil diperbarui.');
    }
}
