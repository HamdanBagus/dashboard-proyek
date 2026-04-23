<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\QcGround;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    // QC TIM GROUND
    public function showGround(Project $project)
    {
        $project->load(['personnel', 'groundReport']);
        $qc = QcGround::firstOrCreate(['project_id' => $project->id]);

        return view('projects.qc.qc_ground', compact('project', 'qc'));
    }

    public function updateGround(Request $request, Project $project)
    {
        $qc = QcGround::where('project_id', $project->id)->first();
        $request->validate([
            'file_tolerance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_inacors' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_google_earth' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_utsb' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
            
            'rev_file_tolerance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_inacors' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_google_earth' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_utsb' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);
        $data = $request->except(['_token', '_method']);

        $items = ['form_log', 'raw_gps', 'report_gps', 'coordinate', 'photo_utsb'];
        foreach ($items as $item) {
            $data["chk_complete_{$item}"] = $request->has("chk_complete_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = $request->has("rev_chk_complete_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_officer_name'] = null;
            
            // RESET 4 NOTES FILE REVISI IF NOT IN REVISION STATUS
            $data['rev_note_file_tolerance'] = null;
            $data['rev_note_file_inacors'] = null;
            $data['rev_note_file_google_earth'] = null;
            $data['rev_note_file_utsb'] = null;
            
            // PUT REVISION FILE TO NULL IF NOT IN REVISION STATUS
            $revFiles = ['rev_file_tolerance', 'rev_file_inacors', 'rev_file_google_earth', 'rev_file_utsb'];
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('uploads')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        // input file ustb and rev_file_ustb  into array to handle upload and deletion in one loop
        $fileFields = ['file_tolerance', 'file_inacors', 'file_google_earth', 'file_utsb'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, ['rev_file_tolerance', 'rev_file_inacors', 'rev_file_google_earth', 'rev_file_utsb']);
        }

        foreach ($fileFields as $field) {
            $isRemoved = $request->input("remove_{$field}") == '1';

            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) Storage::disk('uploads')->delete($qc->$field);
                $data[$field] = null;
            }

            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/ground', 'uploads');
            } elseif (!$isRemoved) {
                unset($data[$field]);
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC Tim Ground berhasil disimpan!');
    }

    //  QC uav photo 
    public function showUavPhoto(Project $project)
    {
        $project->load(['personnel', 'uavReport.logs']);
        $qc = QcUavPhoto::firstOrCreate(['project_id' => $project->id]);

        $uavs = AssetUav::all();
        $cameras = AssetCamera::all();

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
            'rev_file_quality' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_geotag'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_blur'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_overlap' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_gsd'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        $items = ['raw_photo', 'raw_uav', 'base_gps', 'geotag'];
        foreach ($items as $item) {
            $data["chk_complete_{$item}"] = $request->has("chk_complete_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        $revFiles = ['rev_file_quality', 'rev_file_geotag', 'rev_file_blur', 'rev_file_overlap', 'rev_file_gsd'];
        
        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = $request->has("rev_chk_complete_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            // if not in revision status, reset all revision checkboxes to false and notes to null
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_officer_name'] = null;
            
            // reset 5 notes revision if not in revision status
            $data['rev_note_file_quality'] = null;
            $data['rev_note_file_geotag'] = null;
            $data['rev_note_file_blur'] = null;
            $data['rev_note_file_overlap'] = null;
            $data['rev_note_file_gsd'] = null;
            
            // delete file revision if not in revision status
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('uploads')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        $fileFields = ['file_quality', 'file_geotag', 'file_blur', 'file_overlap', 'file_gsd'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, $revFiles);
        }

        foreach ($fileFields as $field) {
            $isRemoved = $request->input("remove_{$field}") == '1';

            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) Storage::disk('uploads')->delete($qc->$field);
                $data[$field] = null; 
            }

            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/uav_photo', 'uploads');
            } elseif (!$isRemoved) {
                unset($data[$field]);
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC UAV Foto Udara berhasil disimpan!');
    }

    //  QC UAV LIDAR 
    public function showUavLidar(Project $project)
    {
        $project->load(['personnel', 'uavReport.logs']);
        $qc = QcUavLidar::firstOrCreate(['project_id' => $project->id]);

        $uavs = AssetUav::all();
        $cameras = AssetCamera::all();

        $totalFlights = $project->uavReport ? $project->uavReport->logs->sum('flight_count') : 0;

        return view('projects.qc.qc_uav_lidar', compact('project', 'qc', 'uavs', 'cameras', 'totalFlights'));
    }

    public function updateUavLidar(Request $request, Project $project)
    {
        $qc = QcUavLidar::where('project_id', $project->id)->first();

        $request->validate([
            'file_gap'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_accuracy'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_gap'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rev_file_accuracy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        $items = ['raw_lidar', 'base_gps', 'pre_processing'];
        foreach ($items as $item) {
            $data["chk_complete_{$item}"] = $request->has("chk_complete_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        $revFiles = ['rev_file_gap', 'rev_file_accuracy'];
        
        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = $request->has("rev_chk_complete_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            foreach ($items as $item) {
                $data["rev_chk_complete_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_officer_name'] = null;
            
            // reset notes revisi if not in revision status
            $data['rev_note_file_gap'] = null;
            $data['rev_note_file_accuracy'] = null;
            
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('uploads')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        $fileFields = ['file_gap', 'file_accuracy'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, $revFiles);
        }

        foreach ($fileFields as $field) {
            $isRemoved = $request->input("remove_{$field}") == '1';

            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) Storage::disk('uploads')->delete($qc->$field);
                $data[$field] = null; 
            }

            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/uav_lidar', 'uploads');
            } elseif (!$isRemoved) {
                unset($data[$field]);
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC UAV LiDAR berhasil disimpan!');
    }

    // QC processing    
    public function showProcessing(Project $project)
    {
        $project->load(['lidarReport.hamparans']);
        $qc = QcProcessing::firstOrCreate(['project_id' => $project->id]);
        $totalHamparan = $project->lidarReport ? $project->lidarReport->hamparans->count() : 0;
        return view('projects.qc.qc_processing', compact('project', 'qc', 'totalHamparan'));
    }

    public function updateProcessing(Request $request, Project $project)
    {
        $qc = QcProcessing::where('project_id', $project->id)->first();

        $fileRules = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        $request->validate([
            'file_accuracy' => $fileRules, 'file_ortho' => $fileRules, 'file_cloud' => $fileRules, 'file_folder' => $fileRules, 'file_hdd' => $fileRules,
            'rev_file_accuracy' => $fileRules, 'rev_file_ortho' => $fileRules, 'rev_file_cloud' => $fileRules, 'rev_file_folder' => $fileRules, 'rev_file_hdd' => $fileRules,
        ]);

        $data = $request->except(['_token', '_method']);

        // handle checkbox for processing QC
        $items = ['project_file', 'ortho', 'dsm', 'dtm', 'accuracy', 'report', 'other'];
        foreach ($items as $item) {
            $data["chk_{$item}"] = $request->has("chk_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        // handle major revision status
        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        // handle revision checkboxes if major revision is true
        $revFiles = ['rev_file_accuracy', 'rev_file_ortho', 'rev_file_cloud', 'rev_file_folder', 'rev_file_hdd'];

        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_{$item}"] = $request->has("rev_chk_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            foreach ($items as $item) {
                $data["rev_chk_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_officer_name'] = null;
            
            // reset notes revisi if not in revision status
            $data['rev_note_file_accuracy'] = null;
            $data['rev_note_file_ortho'] = null;
            $data['rev_note_file_cloud'] = null;
            $data['rev_note_file_folder'] = null;
            $data['rev_note_file_hdd'] = null;
            
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('uploads')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        // handle file uploads and deletions for both original and revision files
        $fileFields = ['file_accuracy', 'file_ortho', 'file_cloud', 'file_folder', 'file_hdd'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, $revFiles);
        }

        foreach ($fileFields as $field) {
            $isRemoved = $request->input("remove_{$field}") == '1';

            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) Storage::disk('uploads')->delete($qc->$field);
                $data[$field] = null;
            }

            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/processing', 'uploads');
            } elseif (!$isRemoved) {
                unset($data[$field]); 
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC Pengolah Data berhasil disimpan!');
    }

    // QC PROJECT MANAGER 
    
    public function showManager(Project $project)
    {
        $qc = QcManager::firstOrCreate(['project_id' => $project->id]);
        return view('projects.qc.qc_manager', compact('project', 'qc'));
    }
    
    public function updateManager(Request $request, Project $project)
    {
        $qc = QcManager::where('project_id', $project->id)->first();

        $fileRules = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        $request->validate([
            'file_report' => $fileRules,
            'file_other'  => $fileRules,
            'rev_file_report' => $fileRules,
            'rev_file_other'  => $fileRules,
        ]);

        $data = $request->except(['_token', '_method']);

        $items = ['report', 'other_docs'];
        foreach ($items as $item) {
            $data["chk_{$item}"] = $request->has("chk_{$item}");
            $data["chk_folder_{$item}"] = $request->has("chk_folder_{$item}");
        }

        $hasRevision = $request->has('has_major_revision') && $request->has_major_revision == '1';
        $data['has_major_revision'] = $hasRevision;

        $revFiles = ['rev_file_report', 'rev_file_other'];

        if ($hasRevision) {
            foreach ($items as $item) {
                $data["rev_chk_{$item}"] = $request->has("rev_chk_{$item}");
                $data["rev_chk_folder_{$item}"] = $request->has("rev_chk_folder_{$item}");
            }
        } else {
            foreach ($items as $item) {
                $data["rev_chk_{$item}"] = 0;
                $data["rev_chk_folder_{$item}"] = 0;
                $data["rev_note_{$item}"] = null;
            }
            $data['rev_qc_date'] = null;
            $data['rev_qc_name'] = null;
            $data['rev_note_file_report'] = null;
            $data['rev_note_file_other'] = null;
            
            foreach ($revFiles as $rf) {
                if ($qc->$rf) Storage::disk('uploads')->delete($qc->$rf);
                $data[$rf] = null;
            }
        }

        $fileFields = ['file_report', 'file_other'];
        if ($hasRevision) {
            $fileFields = array_merge($fileFields, $revFiles);
        }

        foreach ($fileFields as $field) {
            $isRemoved = $request->input("remove_{$field}") == '1';

            if ($isRemoved || $request->hasFile($field)) {
                if ($qc->$field) Storage::disk('uploads')->delete($qc->$field);
                $data[$field] = null; 
            }

            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('qc_files/manager', 'uploads');
            } elseif (!$isRemoved) {
                unset($data[$field]);
            }
        }

        $qc->update($data);
        return back()->with('success', 'Data QC Project Manager berhasil disimpan!');
    }
}