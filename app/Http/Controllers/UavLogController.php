<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\AssetUav;
use App\Models\UavMaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AssetPc;

class UavLogController extends Controller
{
    // list 18 components standart for pre & post flight check, to be used in both show & update methods
    private $standardComponents = [
        'Baterai drone', 'Baterai remote', 'Propeller', 'Motor', 'Servo',
        'Gimbal & Kamera (Payload)', 'GPS', 'Body Frame', 'Checklist', 'Firmware',
        'Laptop GCS', 'Laptop Processing', 'Telemetri', 'Statif', 'Memory Card',
        'Tribach', 'Genset', 'Tool Kit'
    ];

    public function show(Project $project, $uav_id)
    {
        $uav = AssetUav::where('name', $uav_id)->firstOrFail(); 
        $pilot = $project->personnel()->where('role', 'Pilot')->first();

        // get all PCs for the dropdown in the form
        $pcs = AssetPc::all();

        $log = UavMaintenanceLog::firstOrCreate([
            'project_id' => $project->id,
            'uav_id' => $uav->id
        ], [
            'pilot_name' => $pilot ? $pilot->name : null
        ]);

        if ($log->componentChecks()->where('phase', 'sebelum')->count() == 0) {
            foreach ($this->standardComponents as $comp) {
                $log->componentChecks()->create(['phase' => 'sebelum', 'component_name' => $comp]);
            }
        }

        if ($log->componentChecks()->where('phase', 'sesudah')->count() == 0) {
            foreach ($this->standardComponents as $comp) {
                $log->componentChecks()->create(['phase' => 'sesudah', 'component_name' => $comp]);
            }
        }

        $log->load('componentChecks');
        
        $checksBefore = $log->componentChecks->where('phase', 'sebelum')->keyBy('component_name');
        $checksAfter = $log->componentChecks->where('phase', 'sesudah')->keyBy('component_name');
        $components = $this->standardComponents;

        return view('projects.uav_log.show', compact('project', 'uav', 'log', 'components', 'checksBefore', 'checksAfter', 'pcs'));
    }

    public function update(Request $request, Project $project, $uav_id)
    {
        $log = UavMaintenanceLog::where('project_id', $project->id)->where('uav_id', $uav_id)->firstOrFail();

        // Update main Data Log Maintenance UAV
        $log->update($request->only([
            'km_before', 'flight_count_before', 'flight_hours_before',
            'km_after', 'flight_count_after', 'flight_hours_after'
        ]));

        // Loop and Update Data Component Checks for both 'sebelum' and 'sesudah' phases 
        foreach (['sebelum', 'sesudah'] as $phase) {
            foreach ($this->standardComponents as $compName) {
                $inputKeySafe = str_replace([' ', '&', '(', ')'], '_', $compName); 

                $checkRecord = $log->componentChecks()->where('phase', $phase)->where('component_name', $compName)->first();

                if ($checkRecord) {
                    $updateData = [
                        'completeness' => $request->input("complete_{$phase}_{$inputKeySafe}"),
                        'condition'    => $request->input("condition_{$phase}_{$inputKeySafe}", 'baik'),
                        'notes'        => $request->input("note_{$phase}_{$inputKeySafe}")
                    ];

                    // delete and update photo if user requested deletion or uploaded new photo
                    $fileKey = "photo_{$phase}_{$inputKeySafe}";
                    $removeKey = "remove_photo_{$phase}_{$inputKeySafe}";
                    $isRemoved = $request->input($removeKey) == '1';

                    // id user wants to remove existing photo or upload new one, then delete old photo if exists
                    if ($isRemoved || $request->hasFile($fileKey)) {
                        if ($checkRecord->photo_path) Storage::disk('uploads')->delete($checkRecord->photo_path);
                        $updateData['photo_path'] = null; // set to null if removed, will be updated with new path if new file uploaded below
                    }

                    // if there's a new file uploaded, store it and update the path
                    if ($request->hasFile($fileKey)) {
                        $updateData['photo_path'] = $request->file($fileKey)->store("uav_maintenance/{$log->id}", 'uploads');
                    }

                    $checkRecord->update($updateData);
                }
            }
        }

        return back()
                ->with('success', 'Log Maintenance UAV berhasil disimpan!')
                ->with('active_tab', $request->input('active_tab', 'sebelum'));
    }
}