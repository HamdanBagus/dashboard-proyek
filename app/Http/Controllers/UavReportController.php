<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UavReport;
use App\Models\UavPilotLog;
use App\Models\Employee; // Import Model Karyawan
use App\Models\AssetUav; // Import Model Aset UAV
use Illuminate\Http\Request;

class UavReportController extends Controller
{
    /**
     * Tampilkan Halaman Laporan UAV
     */
    public function index(Project $project)
    {
        // 1. Cari atau Buat Laporan UAV
        $report = UavReport::firstOrCreate(
            ['project_id' => $project->id],
            ['aoi_size' => 0] // Default luas 0
        );

        // 2. Siapkan Data Dropdown (Ambil dari Master Data)
        $employees = Employee::all();
        $uavs = AssetUav::all();

        // 3. Hitung Progres Otomatis
        // Total luas yang sudah diakuisisi oleh semua pilot
        $totalAcquired = $report->logs()->sum('area_acquired');

        // Persentase (Hindari pembagian dengan nol)
        $percentage = $report->aoi_size > 0
            ? ($totalAcquired / $report->aoi_size) * 100
            : 0;

        return view('projects.progress.uav', compact(
            'project', 'report', 'employees', 'uavs', 'totalAcquired', 'percentage'
        ));
    }

    /**
     * Update Header Laporan (Tanggal & Luas AOI)
     */
    public function update(Request $request, UavReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'aoi_size' => 'required|numeric|min:0',
        ]);

        $report->update($validated);

        return back()->with('success', 'Data header UAV berhasil diperbarui.');
    }

    /**
     * Simpan Log Harian Pilot
     */
    public function storeLog(Request $request, UavReport $report)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'pilot_id' => 'required|exists:employees,id',
            'assistant_id' => 'nullable|exists:employees,id',
            'uav_id' => 'required|exists:asset_uavs,id',
            'flight_count' => 'required|integer|min:1',
            'area_acquired' => 'required|numeric|min:0',
            'status' => 'required|string', // Dropdown status
            'notes' => 'nullable|string',
        ]);

        $report->logs()->create($validated);

        return back()->with('success', 'Log penerbangan berhasil ditambahkan.');
    }

    /**
     * Hapus Log Pilot
     */
    public function destroyLog(UavPilotLog $log)
    {
        $log->delete();
        return back()->with('success', 'Log berhasil dihapus.');
    }
}
