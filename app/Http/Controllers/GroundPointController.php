<?php

namespace App\Http\Controllers;

use App\Models\GroundReport;
use App\Models\GroundPoint;
use Illuminate\Http\Request;

class GroundPointController extends Controller
{
    /**
     * Simpan Titik Baru (Hanya Nama Dulu)
     */
    public function store(Request $request, GroundReport $report)
    {
        // Validasi input
        $request->validate([
            'name'       => 'required|string|max:255',
            'point_type' => 'required|in:BM,ICP,GCP',
            'quantity'   => 'required|integer|min:1|max:200', // Batasi max 200 agar server tidak hang
        ]);

        $quantity = $request->quantity;
        $prefix = trim($request->name);

        // Jika hanya input 1 titik, simpan nama persis seperti yang diketik
        if ($quantity == 1) {
            $report->points()->create([
                'name'       => $prefix,
                'point_type' => $request->point_type,
            ]);
            
            return back()->with('success', 'Titik ' . $prefix . ' berhasil ditambahkan!');
        }

        // Jika input lebih dari 1, lakukan looping massal
        $pointsData = [];
        
        // Menentukan jumlah digit padding (Jika titik > 99, pakai 3 digit "001", jika tidak pakai 2 digit "01")
        $padLength = $quantity > 99 ? 3 : 2; 

        for ($i = 1; $i <= $quantity; $i++) {
            // Gabungkan Prefix dengan Angka berformat (Contoh: BDSG + 01 = BDSG01)
            $formattedNumber = sprintf("%0" . $padLength . "d", $i);
            $generatedName = $prefix . $formattedNumber;

            $pointsData[] = [
                'ground_report_id' => $report->id,
                'name'             => $generatedName,
                'point_type'       => $request->point_type,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        // Insert massal ke database (jauh lebih cepat daripada insert satu-satu)
        \App\Models\GroundPoint::insert($pointsData);

        return back()->with('success', $quantity . ' titik (' . $prefix . '01 - ' . $prefix . sprintf("%0".$padLength."d", $quantity) . ') berhasil digenerate otomatis!');
    }

    /**
     * Hapus Titik
     */
    public function destroy(GroundPoint $point)
    {
        $point->delete();
        return back()->with('success', 'Titik berhasil dihapus.');
    }

    /**
     * Halaman Edit Progress (Mengirim Data Dropdown Personil)
     */
    public function edit(GroundPoint $point)
    {
        // 1. Ambil data proyek melalui relasi titik -> report -> project
        // (Perhatikan: kita memanggil relasi 'report' karena di fungsi update di bawah Anda menggunakan $point->report)
        $project = $point->report->project;

        // 2. Load data personil dari proyek tersebut
        $project->load('personnel');

        // 3. Filter personil berdasarkan Role untuk dikirim ke Dropdown View
        $surveyors = $project->personnel->where('pivot.role', 'Surveyor');
        // $pengolahData = $project->personnel->where('pivot.role', 'Pengolah Data');

        // 4. Kirim variabel point, surveyors, dan pengolahData ke view
        return view('projects.progress.ground_edit_point', compact('point', 'surveyors'));
    }

    /**
     * Update Progress Titik (Checklist, Tanggal, Surveyor)
     */
    public function update(Request $request, GroundPoint $point)
    {
        // Validasi input
        $validated = $request->validate([

            // Identitas Titik (BARU)
            'name'       => 'required|string|max:255',
            'point_type' => 'required|in:BM,ICP,GCP',

            // Tahap 1: Pemasangan
            'install_status' => 'boolean',
            'install_date' => 'nullable|date',
            'install_surveyor' => 'nullable|string',

            // Tahap 2: Pengukuran
            'measure_status' => 'boolean',
            'measure_date' => 'nullable|date',
            'measure_surveyor' => 'nullable|string',

            // Tahap 3: Pengolahan
            'process_status' => 'boolean',
            'process_date' => 'nullable|date',
            'process_surveyor' => 'nullable|string',

            'notes' => 'nullable|string',
        ]);

        // Fix checkbox: HTML checkbox tidak kirim data jika unchecked.
        
        $point->update([

        // Identitas Titik (BARU)
            'name' => $request->name,
            'point_type' => $request->point_type,

            'install_status' => $request->has('install_status'),
            'install_date' => $request->install_date,
            'install_surveyor' => $request->install_surveyor,

            'measure_status' => $request->has('measure_status'),
            'measure_date' => $request->measure_date,
            'measure_surveyor' => $request->measure_surveyor,

            'process_status' => $request->has('process_status'),
            'process_date' => $request->process_date,
            'process_surveyor' => $request->process_surveyor,

            'notes' => $request->notes,
        ]);

        // Redirect kembali ke halaman Laporan Ground
        return redirect()->route('projects.ground.index', $point->report->project_id)
                         ->with('success', 'Progress titik ' . $point->name . ' berhasil diperbarui.');
    }
}
