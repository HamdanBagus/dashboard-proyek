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

        // Untuk ini masih aman menggunakan back() karena berada di halaman yang sama
        return back()->with('success', 'Waktu pelaksanaan UAV berhasil diperbarui.');
    }

    /**
     * Simpan Log Harian Pilot
     */
    public function storeLog(Request $request, UavReport $report)
    {
        // PERBAIKAN: Ubah min:1 menjadi min:0 agar nilai 0 bisa masuk.
        // Hapus rules 'exists' pada relasi untuk menghindari hidden error redirect.
        $validated = $request->validate([
            'date'          => 'required|date',
            'pilot_id'      => 'required',
            'assistant_id'  => 'nullable',
            'uav_id'        => 'required',
            'flight_count'  => 'required|numeric|min:0', 
            'area_acquired' => 'required|numeric|min:0', 
            'status'        => 'required|string', 
            'notes'         => 'nullable|string',
        ]);

        $report->logs()->create($validated);

        // PERBAIKAN: Redirect eksplisit ke rute index
        return redirect()->route('projects.uav.index', $report->project_id)
                         ->with('success', 'Log penerbangan berhasil ditambahkan.');
    }

    /**
     * FITUR BARU: Update Log Pilot (Dari Modal Edit)
     */
    public function updateLog(Request $request, UavPilotLog $log)
    {
        // Validasi diperlonggar
        $validated = $request->validate([
            'date'          => 'required|date',
            'pilot_id'      => 'required',
            'assistant_id'  => 'nullable',
            'uav_id'        => 'required',
            'flight_count'  => 'required|numeric|min:0',
            'area_acquired' => 'required|numeric|min:0',
            'status'        => 'required|string',
            'notes'         => 'nullable|string',
        ]);

        $log->update($validated);

        // CARA AMAN: Panggil UavReport secara manual menggunakan uav_report_id
        $report = \App\Models\UavReport::find($log->uav_report_id);

        // Redirect eksplisit ke rute index
        return redirect()->route('projects.uav.index', $report->project_id)
                         ->with('success', 'Log penerbangan berhasil diperbarui.');
    }

    /**
     * Hapus Log Pilot
     */
    public function destroyLog(UavPilotLog $log)
    {
        $report = \App\Models\UavReport::find($log->uav_report_id);
        $projectId = $report->project_id;
        
        $log->delete();
        
        // Redirect eksplisit
        return redirect()->route('projects.uav.index', $projectId)
                         ->with('success', 'Log penerbangan berhasil dihapus.');
    }

    /**
     * Rekap Pilot
     */
    public function pilotSummary(Project $project)
    {
        $report = UavReport::with(['logs.pilot', 'logs.uav', 'logs.assistant'])->where('project_id', $project->id)->firstOrFail();

        // 1. Ambil SEMUA log
        $allLogs = $report->logs;

        // 2. PASTIKAN BARIS INI MENGGUNAKAN $allLogs (Bukan $successfulLogs)
        $groupedLogs = $allLogs->groupBy('pilot_id');

        $pilotStats = [];

        foreach ($groupedLogs as $pilotId => $logs) {
            $pilotName = $logs->first()->pilot->name ?? 'Pilot Tidak Diketahui';
            $totalArea = $logs->sum('area_acquired');
            $daysFlown = $logs->pluck('date')->unique()->count();
            $averagePerDay = $daysFlown > 0 ? ($totalArea / $daysFlown) : 0;

            $pilotStats[] = [
                'name' => $pilotName,
                'total_area' => $totalArea,
                'days_flown' => $daysFlown,
                'average_per_day' => $averagePerDay,
                'flight_count' => $logs->sum('flight_count'),
                
                'logs' => $logs->sortByDesc('date') 
            ];
        }

        // Urutkan berdasarkan total area terbanyak
        usort($pilotStats, function($a, $b) {
            return $b['total_area'] <=> $a['total_area'];
        });

        return view('projects.progress.uav_pilots', compact('project', 'pilotStats'));
    }
}