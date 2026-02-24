<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\QcGround; // Import Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage untuk File Upload
use App\Models\QcUavPhoto;
use App\Models\AssetUav;
use App\Models\AssetCamera;
use App\Models\QcUavLidar;
use App\Models\QcProcessing;
use App\Models\QcManager;

class ProjectQcController extends Controller
{
    public function index(Project $project)
    {
        return view('projects.qc.index', compact('project'));
    }

    // --- QC TIM GROUND ---
    public function showGround(Project $project)
    {
        // Load relasi yg dibutuhkan
        $project->load(['personnel', 'groundReport']);
        $qc = QcGround::firstOrCreate(['project_id' => $project->id]);

        return view('projects.qc.qc_ground', compact('project', 'qc'));
    }

    public function updateGround(Request $request, Project $project)
    {
        $qc = QcGround::where('project_id', $project->id)->first();

        // Validasi input & file max 2MB
        $request->validate([
            'file_tolerance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_inacors' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_google_earth' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'file_tolerance', 'file_inacors', 'file_google_earth']);

        // Handle Checkbox (karena HTML tidak mengirim nilai jika tidak dicentang)
        $data['chk_form_log'] = $request->has('chk_form_log');
        $data['chk_raw_gps'] = $request->has('chk_raw_gps');
        $data['chk_report_gps'] = $request->has('chk_report_gps');
        $data['chk_coordinate'] = $request->has('chk_coordinate');
        $data['chk_photo_utsb'] = $request->has('chk_photo_utsb');

        // Handle File Upload
        if ($request->hasFile('file_tolerance')) {
            if ($qc->file_tolerance) Storage::disk('public')->delete($qc->file_tolerance); // Hapus file lama
            $data['file_tolerance'] = $request->file('file_tolerance')->store('qc_files/ground', 'public');
        }
        if ($request->hasFile('file_inacors')) {
            if ($qc->file_inacors) Storage::disk('public')->delete($qc->file_inacors);
            $data['file_inacors'] = $request->file('file_inacors')->store('qc_files/ground', 'public');
        }
        if ($request->hasFile('file_google_earth')) {
            if ($qc->file_google_earth) Storage::disk('public')->delete($qc->file_google_earth);
            $data['file_google_earth'] = $request->file('file_google_earth')->store('qc_files/ground', 'public');
        }

        $qc->update($data);

        return back()->with('success', 'Data QC Tim Ground berhasil disimpan!');
    }
    // --- QC UAV FOTO UDARA ---
    public function showUavPhoto(Project $project)
    {
        $project->load(['personnel', 'uavReport.logs']); // Load relasi
        $qc = QcUavPhoto::firstOrCreate(['project_id' => $project->id]);

        $uavs = AssetUav::all();
        $cameras = AssetCamera::all();

        // Hitung total flight dari uavReport jika ada
        $totalFlights = $project->uavReport ? $project->uavReport->logs->sum('flight_count') : 0;

        return view('projects.qc.qc_uav_photo', compact('project', 'qc', 'uavs', 'cameras', 'totalFlights'));
    }

    public function updateUavPhoto(Request $request, Project $project)
    {
        $qc = QcUavPhoto::where('project_id', $project->id)->first();

        $request->validate([
            'file_quality' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_geotag'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_blur'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_overlap' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_gsd'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'file_quality', 'file_geotag', 'file_blur', 'file_overlap', 'file_gsd']);

        // Handle Checkbox boolean
        $data['chk_raw_photo'] = $request->has('chk_raw_photo');
        $data['chk_raw_uav'] = $request->has('chk_raw_uav');
        $data['chk_base_gps'] = $request->has('chk_base_gps');
        $data['chk_geotag'] = $request->has('chk_geotag');

        // Jika uav_used atau camera_used kosong, set sebagai array kosong agar tidak error
        $data['uav_used'] = $request->uav_used ?? [];
        $data['camera_used'] = $request->camera_used ?? [];

        // Handle File Uploads (Looping biar rapi)
        $fileFields = ['file_quality', 'file_geotag', 'file_blur', 'file_overlap', 'file_gsd'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($qc->$field) Storage::disk('public')->delete($qc->$field);
                $data[$field] = $request->file($field)->store('qc_files/uav_photo', 'public');
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC UAV Foto Udara berhasil disimpan!');
    }
    // --- QC UAV LIDAR ---
    public function showUavLidar(Project $project)
    {
        $project->load(['personnel', 'uavReport.logs']);
        $qc = QcUavLidar::firstOrCreate(['project_id' => $project->id]);

        $uavs = AssetUav::all();
        $cameras = AssetCamera::all();

        // Hitung total flight dari uavReport jika ada
        $totalFlights = $project->uavReport ? $project->uavReport->logs->sum('flight_count') : 0;

        return view('projects.qc.qc_uav_lidar', compact('project', 'qc', 'uavs', 'cameras', 'totalFlights'));
    }

    public function updateUavLidar(Request $request, Project $project)
    {
        $qc = QcUavLidar::where('project_id', $project->id)->first();

        $request->validate([
            'file_gap'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_accuracy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'file_gap', 'file_accuracy']);

        // Handle Checkbox
        $data['chk_raw_lidar'] = $request->has('chk_raw_lidar');
        $data['chk_base_gps'] = $request->has('chk_base_gps');
        $data['chk_pre_processing'] = $request->has('chk_pre_processing');

        // Handle arrays
        $data['uav_used'] = $request->uav_used ?? [];
        $data['camera_used'] = $request->camera_used ?? [];

        // Handle File Uploads
        $fileFields = ['file_gap', 'file_accuracy'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($qc->$field) Storage::disk('public')->delete($qc->$field);
                $data[$field] = $request->file($field)->store('qc_files/uav_lidar', 'public');
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC UAV LiDAR berhasil disimpan!');
    }
    // --- QC PENGOLAH DATA ---
    public function showProcessing(Project $project)
    {
        // Load data proyek dan laporan lidar untuk menghitung hamparan
        $project->load(['lidarReport.hamparans']);
        $qc = QcProcessing::firstOrCreate(['project_id' => $project->id]);

        $totalHamparan = $project->lidarReport ? $project->lidarReport->hamparans->count() : 0;

        return view('projects.qc.qc_processing', compact('project', 'qc', 'totalHamparan'));
    }

    public function updateProcessing(Request $request, Project $project)
    {
        $qc = QcProcessing::where('project_id', $project->id)->first();

        // Validasi ekstensi semua file
        $fileRules = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        $request->validate([
            'c1_file_accuracy' => $fileRules, 'c1_file_ortho' => $fileRules, 'c1_file_cloud' => $fileRules, 'c1_file_folder' => $fileRules, 'c1_file_hdd' => $fileRules,
            'c2_file_accuracy' => $fileRules, 'c2_file_ortho' => $fileRules, 'c2_file_cloud' => $fileRules, 'c2_file_folder' => $fileRules, 'c2_file_hdd' => $fileRules,
        ]);

        $data = $request->except(['_token', '_method']);

        // Handle Checkbox
        $checklists = ['chk_project_file', 'chk_ortho', 'chk_dsm', 'chk_dtm', 'chk_accuracy', 'chk_report', 'chk_other'];
        foreach ($checklists as $chk) {
            $data[$chk] = $request->has($chk);
        }

        // Handle File Uploads
        $fileFields = [
            'c1_file_accuracy', 'c1_file_ortho', 'c1_file_cloud', 'c1_file_folder', 'c1_file_hdd',
            'c2_file_accuracy', 'c2_file_ortho', 'c2_file_cloud', 'c2_file_folder', 'c2_file_hdd'
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($qc->$field) Storage::disk('public')->delete($qc->$field);
                $data[$field] = $request->file($field)->store('qc_files/processing', 'public');
            } else {
                unset($data[$field]); // Cegah nimpa null jika tidak upload baru
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC Pengolahan berhasil disimpan!');
    }

    public function showManager(Project $project)
    {
        $qc = QcManager::firstOrCreate(['project_id' => $project->id]);
        return view('projects.qc.qc_manager', compact('project', 'qc'));
    }
    
    public function updateManager(Request $request, Project $project)
    {
        $qc = QcManager::where('project_id', $project->id)->first();

        // Validasi ekstensi file
        $fileRules = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        $request->validate([
            'file_report' => $fileRules,
            'file_other' => $fileRules,
        ]);

        $data = $request->except(['_token', '_method']);

        // Handle Checkbox
        $data['chk_report'] = $request->has('chk_report');
        $data['chk_other_docs'] = $request->has('chk_other_docs');

        // Handle File Uploads (1 Pengecek saja)
        $fileFields = ['file_report', 'file_other'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($qc->$field) Storage::disk('public')->delete($qc->$field);
                $data[$field] = $request->file($field)->store('qc_files/manager', 'public');
            } else {
                unset($data[$field]); // Cegah nimpa null
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC Project Manager berhasil disimpan!');
    }
}
