<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PhotoReport;
use App\Models\PhotoHamparan;
use App\Models\PhotoOutput;
use App\Models\PhotoProgress;
use App\Models\AssetPc; // Untuk dropdown PC
use Illuminate\Http\Request;

class PhotoReportController extends Controller
{
    /**
     * Halaman Utama Laporan Foto Udara (Header + List Hamparan + List Output)
     */
    public function index(Project $project)
    {
        // 1. Cari atau Buat Laporan
        $report = PhotoReport::firstOrCreate(
            ['project_id' => $project->id],
            ['status' => 'On Progress']
        );

        // 2. Ambil data relasi
        $hamparans = $report->hamparans;
        $outputs = $report->outputs;

        return view('projects.progress.photo.index', compact('project', 'report', 'hamparans', 'outputs'));
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
    public function storeOutput(Request $request, PhotoReport $report)
    {
        $report->outputs()->create($request->validate([
            'filename' => 'required|string', // Jenis Output (Orthophoto, DSM)
            'format' => 'required|string',   // TIF, ECW
            'size_gb' => 'nullable|numeric',
            'location' => 'nullable|string',
            'checklist' => 'boolean', // Checkbox
        ]));
        return back()->with('success', 'Output berhasil ditambahkan.');
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
        $project = $hamparan->photoReport->project; // Untuk breadcrumb
        $pcs = AssetPc::all(); // Untuk dropdown PC
        // 2. Load data personil proyek tersebut
        $project->load('personnel');

        // 3. Filter khusus untuk role "Pengolah Data"
        $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');

        return view('projects.progress.photo.show_hamparan', compact('hamparan', 'project', 'pcs','pengolahData'));
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
}
