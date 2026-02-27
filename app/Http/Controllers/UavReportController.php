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
        // 1. Cari atau Buat Laporan UAV (Tanpa aoi_size karena sudah pakai area_size dari Project)
        $report = UavReport::firstOrCreate(
            ['project_id' => $project->id]
        );

        // 2. Siapkan Data Dropdown
        // (Tips: Ke depannya, Anda bisa mengubah ini menjadi $project->personnel
        // untuk filter khusus role Pilot seperti di laporan Foto/LiDAR)
        $employees = Employee::all();
        $uavs = AssetUav::all();

        // 3. Hitung Progres Otomatis
        // Total luas yang sudah diakuisisi oleh semua penerbangan
        $totalAcquired = $report->logs()->sum('area_acquired');

        // 4. Hitung Persentase (Mengambil luas dari tabel Project)
        // Jika area_size 0 (belum diinput), jadikan 1 agar tidak terjadi error pembagian dengan 0
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
        // Hapus aoi_size, hanya validasi tanggal
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
        return back()->with('success', 'Log penerbangan berhasil dihapus.');
    }
}
