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

        // 1. Validasi input & file max 2MB (Termasuk file revisi)
        $request->validate([
            'file_tolerance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_inacors' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_google_earth' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_tolerance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_inacors' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_google_earth' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Ambil semua data teks/inputan selain file
        $data = $request->except([
            '_token', '_method', 
            'file_tolerance', 'file_inacors', 'file_google_earth',
            'rev_file_tolerance', 'rev_file_inacors', 'rev_file_google_earth'
        ]);

        // 2. Handle Checkbox QC UTAMA
        $items = ['form_log', 'raw_gps', 'report_gps', 'coordinate', 'photo_utsb'];
        foreach ($items as $item) {
            $data["chk_complete_{$item}"] = $request->has("chk_complete_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        // 3. Handle Status Revisi Mayor
        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        // 4. Handle Checkbox & Pembersihan QC REVISI
        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = $request->has("rev_chk_complete_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            // Bersihkan data revisi jika diganti ke "TIDAK ADA"
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_officer_name'] = null;
            
            // Hapus file revisi fisik
            $revFiles = ['rev_file_tolerance', 'rev_file_inacors', 'rev_file_google_earth'];
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('public')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        // 5. Handle File Uploads & Tombol Hapus File
        // Hanya proses file revisi jika statusnya memang "Ada Revisi"
        $fileFields = ['file_tolerance', 'file_inacors', 'file_google_earth'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, ['rev_file_tolerance', 'rev_file_inacors', 'rev_file_google_earth']);
        }

        foreach ($fileFields as $field) {
            // Cek apakah user menekan tombol hapus (remove_namafile = 1)
            $isRemoved = $request->input("remove_{$field}") == '1';

            // Jika dihapus ATAU ada file baru, hapus file fisik lama
            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) {
                    Storage::disk('public')->delete($qc->$field);
                }
                $data[$field] = null; // Defaultkan ke null
            }

            // Jika ada upload file baru, simpan
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/ground', 'public');
            } elseif (!$isRemoved) {
                // Jika tidak diapa-apakan, cegah kolom database tertimpa null
                unset($data[$field]);
            }
        }

        // 6. Update Database
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
