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
        $hamparans = $report->hamparans()->with(['progresses', 'outputs'])->get();
        
        // Hitung untuk masing-masing baris tabel di view
        foreach ($hamparans as $h) {
            $totalT = $h->progresses->count();
            $selesaiT = $h->progresses->where('status', 'Selesai')->count();
            $pctTahapan = $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;

            $totalO = $h->outputs->count();
            $selesaiO = $h->outputs->where('checklist', 1)->count();
            $pctOutput = $totalO > 0 ? ($selesaiO / $totalO) * 100 : 0;

            $h->persentase_gabungan = ($totalO > 0) ? (($pctTahapan + $pctOutput) / 2) : $pctTahapan;
        }

        // PANGGIL RUMUS DARI MODEL (Dijamin 100% sama persis dengan Dashboard)
        $pctOverall = $report->overall_progress;
        $hamparanCount = $hamparans->count();

        return view('projects.progress.lidar.index', compact('project', 'report', 'hamparans', 'pctOverall', 'hamparanCount'));
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
        $project->load('personnel');
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');

        // --- HITUNG PROGRESS HAMPARAN INI ---
        
        // 1. Progress Tahapan Pengolahan
        $totalTahapan = $hamparan->progresses->count();
        $tahapanSelesai = $hamparan->progresses->where('status', 'Selesai')->count();
        $pctTahapan = $totalTahapan > 0 ? ($tahapanSelesai / $totalTahapan) * 100 : 0;

        // 2. Progress Ketersediaan Output
        $totalOutput = $hamparan->outputs->count();
        $outputSelesai = $hamparan->outputs->where('checklist', 1)->count();
        $pctOutput = $totalOutput > 0 ? ($outputSelesai / $totalOutput) * 100 : 0;

        // 3. Persentase Gabungan
        // Jika belum ada output yang didaftarkan, nilai diambil 100% dari tahapan saja
        if ($totalOutput > 0) {
            $persentase = ($pctTahapan + $pctOutput) / 2;
        } else {
            $persentase = $pctTahapan;
        }

        // Kirim semua variabel ke tampilan Blade
        return view('projects.progress.lidar.show_hamparan', compact(
            'hamparan', 'project', 'pcs', 'pengolahData',
            'totalTahapan', 'tahapanSelesai', 'totalOutput', 'outputSelesai', 'persentase'
        ));
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

    public function storeOutput(Request $request, LidarHamparan $hamparan)
    {
        // Validasi disesuaikan agar bisa menerima input bebas (datalist)
        $validated = $request->validate([
            'filename' => 'required|string|max:255',
            'format' => 'required|string|max:255',
            'checklist' => 'required|boolean'
        ]);

        $hamparan->outputs()->create($validated);

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
