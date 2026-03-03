<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AssetUav;
use App\Models\AssetCamera;
use App\Models\AssetPc;
use Illuminate\Http\Request;
use App\Models\AssetGps;

class AssetManagementController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        $uavs = AssetUav::latest()->get();
        $cameras = AssetCamera::latest()->get();
        $pcs = AssetPc::latest()->get();
        $gps_units = AssetGps::all();

        return view('management.index', compact('employees', 'uavs', 'cameras', 'pcs','gps_units'));
    }

    // --- CRUD KARYAWAN ---
    public function storeEmployee(Request $request) {
        Employee::create($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'Karyawan berhasil ditambahkan.');
    }
    public function destroyEmployee(Employee $employee) {
        $employee->delete();
        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

    // --- CRUD UAV ---
    public function storeUav(Request $request) {
        AssetUav::create($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'UAV berhasil ditambahkan.');
    }
    public function destroyUav(AssetUav $uav) {
        $uav->delete();
        return back()->with('success', 'UAV berhasil dihapus.');
    }

    // --- CRUD KAMERA ---
    public function storeCamera(Request $request) {
        AssetCamera::create($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'Kamera berhasil ditambahkan.');
    }
    public function destroyCamera(AssetCamera $camera) {
        $camera->delete();
        return back()->with('success', 'Kamera berhasil dihapus.');
    }

    // --- CRUD PC ---
    public function storePc(Request $request) {
        AssetPc::create($request->validate([
            'name' => 'required|string|max:255',
            'spec' => 'nullable|string'
        ]));
        return back()->with('success', 'PC berhasil ditambahkan.');
    }
    public function destroyPc(AssetPc $pc) {
        $pc->delete();
        return back()->with('success', 'PC berhasil dihapus.');
    }
    // --- FUNGSI UNTUK GPS ---
    public function storeGps(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        AssetGps::create($validated);

        return back()->with('success', 'Aset GPS berhasil ditambahkan.');
    }

    public function destroyGps(AssetGps $gps)
    {
        $gps->delete();
        return back()->with('success', 'Aset GPS berhasil dihapus.');
    }
}
