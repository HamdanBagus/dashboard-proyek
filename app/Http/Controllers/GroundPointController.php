<?php

namespace App\Http\Controllers;

use App\Models\GroundReport;
use App\Models\GroundPoint;
use Illuminate\Http\Request;

class GroundPointController extends Controller
{
    //Store new Ground Point(s)
     
    public function store(Request $request, GroundReport $report)
    {
        // Validate input
        $request->validate([
            'name'       => 'required|string|max:255',
            'point_type' => 'required|in:BM,ICP,GCP',
            'quantity'   => 'required|integer|min:1|max:200', // limit max 200 for safety
        ]);

        $quantity = $request->quantity;
        $prefix = trim($request->name);

        // if quantity is 1, just create a single point with the given name
        if ($quantity == 1) {
            $report->points()->create([
                'name'       => $prefix,
                'point_type' => $request->point_type,
            ]);
            
            return back()->with('success', 'Titik ' . $prefix . ' berhasil ditambahkan!');
        }

        // if quantity > 1, generate points with incremental numbering (e.g., BDSG01, BDSG02, ...)
        $pointsData = [];
        
        // define padding length based on quantity (e.g., 2 digits for up to 99, 3 digits for 100-999)
        $padLength = $quantity > 99 ? 3 : 2; 

        for ($i = 1; $i <= $quantity; $i++) {
            // merge prefix with formatted number (e.g., BDSG + 01, BDSG + 02, ...)
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

        // Insert generated points into database
        \App\Models\GroundPoint::insert($pointsData);

        return back()->with('success', $quantity . ' titik (' . $prefix . '01 - ' . $prefix . sprintf("%0".$padLength."d", $quantity) . ') berhasil digenerate otomatis!');
    }

        // Delete Ground Point
    public function destroy(GroundPoint $point)
    {
        $point->delete();
        return back()->with('success', 'Titik berhasil dihapus.');
    }


        // Update Ground Point
    public function update(Request $request, GroundPoint $point)
    {
        $validated = $request->validate([

            // Identity of the Point
            'name'       => 'required|string|max:255',
            'point_type' => 'required|in:BM,ICP,GCP',

            // stage 1: Installation
            'install_status' => 'boolean',
            'install_date' => 'nullable|date',
            'install_surveyor' => 'nullable|string',

            // stage 2: Measurement
            'measure_status' => 'boolean',
            'measure_date' => 'nullable|date',
            'measure_surveyor' => 'nullable|string',

            // stage 3: Processing
            'process_status' => 'boolean',
            'process_date' => 'nullable|date',
            'process_surveyor' => 'nullable|string',

            'notes' => 'nullable|string',
        ]);        
        $point->update([
        // Identity of the Point
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

        // Redirect back to the ground report page with success message
        return back()->with('success', 'Progress titik ' . $point->name . ' berhasil diperbarui.');
    }
    public function bulkUpdate(Request $request, GroundReport $report)
    {
        $request->validate([
            'point_ids' => 'required|string', // Berisi ID yang dipisahkan koma dari JS
        ]);

        // Pecah ID menjadi array dan pastikan titik-titik tersebut adalah milik report ini (keamanan)
        $ids = explode(',', $request->point_ids);
        $pointsQuery = GroundPoint::whereIn('id', $ids)->where('ground_report_id', $report->id);
        
        $updateData = [];

        // 1. Cek apakah user mencentang 'Update Pemasangan'
        if ($request->has('update_install')) {
            $updateData['install_status'] = $request->has('install_status') ? 1 : 0;
            $updateData['install_date'] = $request->install_date;
            $updateData['install_surveyor'] = $request->install_surveyor;
        }

        // 2. Cek apakah user mencentang 'Update Pengukuran'
        if ($request->has('update_measure')) {
            $updateData['measure_status'] = $request->has('measure_status') ? 1 : 0;
            $updateData['measure_date'] = $request->measure_date;
            $updateData['measure_surveyor'] = $request->measure_surveyor;
        }

        // 3. Cek apakah user mencentang 'Update Pengolahan'
        if ($request->has('update_process')) {
            $updateData['process_status'] = $request->has('process_status') ? 1 : 0;
            $updateData['process_date'] = $request->process_date;
            $updateData['process_surveyor'] = $request->process_surveyor;
        }

        // Eksekusi update massal jika ada data yang dicentang
        if (!empty($updateData)) {
            $pointsQuery->update($updateData);
        }

        $count = count($ids);
        return back()->with('success', "Progress $count titik berhasil di-update secara massal!");
    }
}
