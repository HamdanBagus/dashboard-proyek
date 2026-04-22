<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Services\ProgressCalculatorService;



class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        $search = $request->input('search');

        // filter search
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // sort
        $sort = $request->input('sort', 'newest'); // default sort by newest

        match ($sort) {
            'az'     => $query->orderBy('name', 'asc'),
            'za'     => $query->orderBy('name', 'desc'),
            'oldest' => $query->orderBy('start_date', 'asc'),
            default  => $query->latest('start_date','desc'), 
        };

        // pagination
        $projects = $query->paginate(10);

        return view('projects.index', compact('projects', 'search'));
    }
    public function create()
    {
        
        // only admin can access this page
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
        abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
    }
    // load data asset for dropdown selection in create project form
        $uavs = \App\Models\AssetUav::all();
        $cameras = \App\Models\AssetCamera::all();
        $pcs = \App\Models\AssetPc::all();
        $gps_units = \App\Models\AssetGps::all(); 

        return view('projects.create', compact('uavs', 'cameras', 'pcs', 'gps_units'));
    }

    //store new project to database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:projects,code',
            'client_name' => 'required|string',
            'client_address' => 'nullable|string',
            'project_location' => 'nullable|string',
            'area_size' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            'planned_uavs' => 'nullable|array',
            'planned_cameras' => 'nullable|array',
            'planned_gps' => 'nullable|array',
            'planned_pcs' => 'nullable|array',
            
            'takeoff_count' => 'nullable|integer|min:0',
            'control_point_count' => 'nullable|integer|min:0',

            'products' => 'nullable|array',
            'products.*' => 'nullable|string',

            'product_specs' => 'nullable|array',
            'product_specs.*' => 'nullable|string',

            'point_codes' => 'nullable|array',
            'point_codes.*' => 'nullable|string',

            'tie_points' => 'nullable|array',
            'tie_points.*' => 'nullable|string',
        ]);

        // Function for cleaning up device arrays (removing entries where 'id' is empty)
        $cleanArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items, function ($item) {
                // save only if 'id' is not empty
                return !empty($item['id']); 
            }));
        };

        // implement the function
        $validated['planned_uavs'] = $cleanArray($request->planned_uavs);
        $validated['planned_cameras'] = $cleanArray($request->planned_cameras);
        $validated['planned_gps'] = $cleanArray($request->planned_gps);
        $validated['planned_pcs'] = $cleanArray($request->planned_pcs);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }
    public function show(Project $project)
    {
        $project->load([
            'personnel', 
            'groundReport.points', 
            'uavReport.logs', 
            'photoReport.hamparans.outputs', 'photoReport.hamparans.progresses',
            'lidarReport.hamparans.outputs', 'lidarReport.hamparans.progresses'
        ]);
        $employees = \App\Models\Employee::orderBy('name', 'asc')->get();
        // PROGRESS GROUND 
        $groundProgress = \App\Services\ProgressCalculatorService::calculateGroundProgress($project, $project->groundReport);

        // PROGRESS UAV 
        $uavProgress = 0;
        if ($project->uavReport) {
            // use the service to calculate UAV progress and get the percentage
            $uavData = \App\Services\ProgressCalculatorService::calculateUavProgress($project, $project->uavReport);
            $uavProgress = $uavData['persentase'];
        }

        // PROGRESS FOTO UDARA 
        $photoProgress = 0;
        if ($project->photoReport) {
            $photoProgress = \App\Services\ProgressCalculatorService::calculatePhotoReportOverallProgress($project->photoReport);
        }

        // PROGRESS LIDAR 
        $lidarProgress = 0;
        if ($project->lidarReport) {
            $lidarProgress = \App\Services\ProgressCalculatorService::calculateLidarReportOverallProgress($project->lidarReport);
        }

        // limit max 100% for each progress type
        $groundProgress = min($groundProgress, 100);
        $uavProgress    = min($uavProgress, 100);
        $photoProgress  = min($photoProgress, 100);
        $lidarProgress  = min($lidarProgress, 100);

        
        // calculate total project progress as average of all types 
        
        $totalProjectProgress = ($groundProgress + $uavProgress + $photoProgress + $lidarProgress) / 4;

        return view('projects.show', compact(
            'project', 'employees', 'totalProjectProgress',
            'groundProgress', 'uavProgress', 'photoProgress', 'lidarProgress'
        ));
    }
    // add new personnel to project
    public function storePersonnel(Request $request, Project $project)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'role' => 'required|string'
        ]);

        // attach personnel to project with specific role 
        $project->personnel()->attach($request->employee_id, ['role' => $request->role]);

        return back()->with('success', 'Personil berhasil ditambahkan ke proyek.');
    }
    // delete personnel from project
    public function destroyPersonnel(Project $project, $employee_id, $role)
    {
        // delete the specific personnel with role from the pivot table
        \Illuminate\Support\Facades\DB::table('project_personnel')
            ->where('project_id', $project->id)
            ->where('employee_id', $employee_id)
            ->where('role', $role)
            ->delete();

        return back()->with('success', 'Personil berhasil dihapus dari proyek.');
    }
    // edit project form
    public function edit(Project $project)
    {
        $uavs = \App\Models\AssetUav::all();
        $cameras = \App\Models\AssetCamera::all();
        $pcs = \App\Models\AssetPc::all();
        $gps_units = \App\Models\AssetGps::all();
        return view('projects.edit', compact('project','uavs', 'cameras', 'pcs', 'gps_units'));
    }

    // save update project to database
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'code' => 'required|unique:projects,code,' . $project->id, 
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_address' => 'nullable|string',
            'project_location' => 'nullable|string',
            'area_size' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:planning,ongoing,finished',
            
            'takeoff_count' => 'nullable|integer|min:0',
            'control_point_count' => 'nullable|integer|min:0',

            // validae format araray for planned assets
            'planned_uavs' => 'nullable|array',
            'planned_cameras' => 'nullable|array',
            'planned_gps' => 'nullable|array',
            'planned_pcs' => 'nullable|array',
            
            // Validate format array for preparation details (products, specs, point codes, tie points)
            'products' => 'nullable|array',
            'product_specs' => 'nullable|array',
            'point_codes' => 'nullable|array',
            'tie_points' => 'nullable|array',
        ]);

        // cleaning functions for array inputs
        $cleanDeviceArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items, function ($item) {
                return !empty($item['id']); 
            }));
        };

        // cleaning function for text arrays (products, specs, point codes, tie points)
        $cleanTextArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items)); 
        };

        // clean up planned assets arrays
        $validated['planned_uavs'] = $cleanDeviceArray($request->planned_uavs);
        $validated['planned_cameras'] = $cleanDeviceArray($request->planned_cameras);
        $validated['planned_gps'] = $cleanDeviceArray($request->planned_gps);
        $validated['planned_pcs'] = $cleanDeviceArray($request->planned_pcs);

        // clean up preparation details arrays
        $validated['products'] = $cleanTextArray($request->products);
        $validated['product_specs'] = $cleanTextArray($request->product_specs);
        $validated['point_codes'] = $cleanTextArray($request->point_codes);
        $validated['tie_points'] = $cleanTextArray($request->tie_points);

        // update project with validated data
        $project->update($validated);

        return redirect()->route('projects.show', $project->id)->with('success', 'Detail proyek berhasil diperbarui!');
    }

    // delete project 
    public function destroy(Project $project)
    {
        // because of the foreign key constraints with cascade on delete, deleting the project will automatically delete all related data in other tables (reports, points, personnel associations, etc.)
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyek beserta seluruh datanya berhasil dihapus!');
    }
}
