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

    // CRUD EMPLOYEE
    public function storeEmployee(Request $request) {
        Employee::create($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'Karyawan berhasil ditambahkan.');
    }
    public function destroyEmployee(Employee $employee) {
        $employee->delete();
        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

    // CRUD UAV
    public function storeUav(Request $request) {
        // validate input
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'pic_id'        => 'nullable|exists:employees,id', 
        ]);

        // save to database
        AssetUav::create($validatedData);

        // redirect back with success message
        return back()->with('success', 'Asset UAV berhasil ditambahkan beserta detailnya.');
    }
    public function destroyUav(AssetUav $uav) {
        $uav->delete();
        return back()->with('success', 'UAV berhasil dihapus.');
    }

    //  CRUD CAMERA 
    public function storeCamera(Request $request) {
        AssetCamera::create($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'Kamera berhasil ditambahkan.');
    }
    public function destroyCamera(AssetCamera $camera) {
        $camera->delete();
        return back()->with('success', 'Kamera berhasil dihapus.');
    }

    // CRUD PC
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
    // CRUD GPS
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
    public function updateEmployee(Request $request, Employee $employee) {
        $employee->update($request->validate(['name' => 'required|string|max:255']));
        return back()->with('success', 'Data Karyawan berhasil diperbarui.');
    }

    public function updateUav(Request $request, AssetUav $uav) {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'pic_id'        => 'nullable|exists:employees,id',
        ]);

        $uav->update($validatedData);
        return back()->with('success', 'Asset UAV berhasil diperbarui.');
    }
}
