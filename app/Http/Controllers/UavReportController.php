<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UavReport;
use App\Models\UavPilotLog;
use App\Models\Employee;
use App\Models\AssetUav;
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
            ['project_id' => $project->id]
        );

        // 2. Siapkan Data Dropdown
        $employees = Employee::all();
        $uavs = AssetUav::all();

        // 3. Hitung Progres Otomatis (PERBAIKAN: Hanya hitung yang berstatus 'Finished Flight')
        $totalAcquired = $report->logs()->where('status', 'Finished Flight')->sum('area_acquired');

        // 4. Hitung Persentase
        $luasProyek = $project->area_size > 0 ? $project->area_size : 1;
        $percentage = ($totalAcquired / $luasProyek) * 100;

        return view('projects.progress.uav', compact(
            'project', 'report', 'employees', 'uavs', 'totalAcquired', 'percentage'
        ));
    }

    /**
     * Update Header Laporan (Hanya Tanggal Pelaksanaan)
     */
    public function update(Request $request, UavReport $report)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $report->update($validated);

        return back()->with('success', 'Waktu pelaksanaan UAV berhasil diperbarui.');
    }

    /**
     * Simpan Log Harian Pilot
     */
    public function storeLog(Request $request, UavReport $report)
    {
        // PERBAIKAN: Ubah min:1 menjadi min:0 agar nilai 0 bisa masuk
        $validated = $request->validate([
            'date' => 'required|date',
            'pilot_id' => 'required|exists:employees,id',
            'assistant_id' => 'nullable|exists:employees,id',
            'uav_id' => 'required|exists:asset_uavs,id',
            'flight_count' => 'required|integer|min:0', 
            'area_acquired' => 'required|numeric|min:0', 
            'status' => 'required|string', 
            'notes' => 'nullable|string',
        ]);

        $report->logs()->create($validated);

        return back()->with('success', 'Log penerbangan berhasil ditambahkan.');
    }

    /**
     * FITUR BARU: Update Log Pilot (Dari Modal Edit)
     */
    public function updateLog(Request $request, UavPilotLog $log)
    {
        // Validasi yang sama persis dengan storeLog
        $validated = $request->validate([
            'date' => 'required|date',
            'pilot_id' => 'required|exists:employees,id',
            'assistant_id' => 'nullable|exists:employees,id',
            'uav_id' => 'required|exists:asset_uavs,id',
            'flight_count' => 'required|integer|min:0',
            'area_acquired' => 'required|numeric|min:0',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $log->update($validated);

        return back()->with('success', 'Log penerbangan berhasil diperbarui.');
    }

    /**
     * Hapus Log Pilot
     */
    public function destroyLog(UavPilotLog $log)
    {
        $log->delete();
        return back()->with('success', 'Log penerbangan berhasil dihapus.');
    }
}