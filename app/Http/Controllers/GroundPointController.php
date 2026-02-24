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
            'name' => 'required|string|max:255',
        ]);

        // Simpan ke database
        $report->points()->create([
            'name' => $request->name,
            // Status lainnya default false (sesuai migration)
        ]);

        return back()->with('success', 'Titik berhasil ditambahkan!');
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
     * Halaman Edit Progress (Akan kita buat di langkah selanjutnya)
     */
    public function edit(GroundPoint $point)
    {
        return view('projects.progress.ground_edit_point', compact('point'));
    }
    /**
     * Update Progress Titik (Checklist, Tanggal, Surveyor)
     */
    public function update(Request $request, GroundPoint $point)
    {
        // Validasi input
        $validated = $request->validate([
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
        // Kita set default false jika tidak ada di request.
        $point->update([
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
