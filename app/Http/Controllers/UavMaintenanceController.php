<?php

namespace App\Http\Controllers;

use App\Models\AssetUav;
use App\Models\UavMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UavMaintenanceController extends Controller
{
    public function index()
    {
        // Ambil semua UAV untuk dropdown
        $uavs = AssetUav::orderBy('name')->get();
        // Ambil data maintenance terbaru beserta data UAV-nya
        $maintenances = UavMaintenance::with('uav')->latest()->get();

        return view('maintenances.index', compact('uavs', 'maintenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_uav_id' => 'required|exists:asset_uavs,id'
        ]);

        // Buat record kosong untuk UAV yang dipilih
        UavMaintenance::create([
            'asset_uav_id' => $request->asset_uav_id
        ]);

        return back()->with('success', 'UAV berhasil ditambahkan ke daftar maintenance.');
    }

    public function update(Request $request, UavMaintenance $uavMaintenance)
    {
        $validated = $request->validate([
            'kilometer' => 'nullable|integer',
            'service_location' => 'nullable|string|max:255',
            'delivery_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:delivery_date',
            'issue_notes' => 'nullable|string',
            'replaced_parts' => 'nullable|string',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        // Handle file upload
        if ($request->hasFile('documentation')) {
            // Hapus file lama jika ada
            if ($uavMaintenance->documentation) {
                Storage::disk('uploads')->delete($uavMaintenance->documentation);
            }
            // Simpan file baru
            $path = $request->file('documentation')->store('maintenances', 'uploads');
            $validated['documentation'] = $path;
        }

        $uavMaintenance->update($validated);

        return back()->with('success', 'Data maintenance berhasil diupdate.');
    }

    public function destroy(UavMaintenance $uavMaintenance)
    {
        if ($uavMaintenance->documentation) {
            Storage::disk('uploads')->delete($uavMaintenance->documentation);
        }
        $uavMaintenance->delete();
        
        return back()->with('success', 'Data maintenance dihapus.');
    }
}