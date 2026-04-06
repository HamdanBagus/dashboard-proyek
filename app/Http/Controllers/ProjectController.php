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
    
    /**
     * Menampilkan daftar proyek.
     */
    public function index(Request $request)
    {
        $query = Project::query();
        $search = $request->input('search');

        // 1. Filter Pencarian Teks (Kode atau Nama)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 2. Filter Urutan (Sorting)
        if ($request->filled('sort')) {
            if ($request->sort === 'az') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort === 'za') {
                $query->orderBy('name', 'desc');
            } elseif ($request->sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } else {
                $query->latest(); // newest
            }
        } else {
            // Default jika tidak ada pilihan sort
            $query->latest(); 
        }

        $projects = $query->paginate(10);

        return view('projects.index', compact('projects', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        // Hanya Admin yang boleh akses halaman tambah
        if (!Auth::check() || Auth::user()?->role !== 'admin') {
        abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
    }
    // Panggil semua master data aset
        $uavs = \App\Models\AssetUav::all();
        $cameras = \App\Models\AssetCamera::all();
        $pcs = \App\Models\AssetPc::all();
        $gps_units = \App\Models\AssetGps::all(); // Model baru yang baru saja kita buat

        return view('projects.create', compact('uavs', 'cameras', 'pcs', 'gps_units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
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
            // Validasi Data Persiapan
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

        // Fungsi kecil untuk membersihkan array kosong (jika user tidak memilih alat)
        $cleanArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items, function ($item) {
                // Hanya simpan yang ID alatnya tidak kosong
                return !empty($item['id']); 
            }));
        };

        // Terapkan fungsi pembersih ke data input
        $validated['planned_uavs'] = $cleanArray($request->planned_uavs);
        $validated['planned_cameras'] = $cleanArray($request->planned_cameras);
        $validated['planned_gps'] = $cleanArray($request->planned_gps);
        $validated['planned_pcs'] = $cleanArray($request->planned_pcs);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }
    public function show(Project $project)
    {
        // 1. Load relasi agar tidak N+1 Query
        $project->load([
            'personnel', 
            'groundReport.points', 
            'uavReport.logs', 
            'photoReport.hamparans.outputs', 'photoReport.hamparans.progresses',
            'lidarReport.hamparans.outputs', 'lidarReport.hamparans.progresses'
        ]);

        $employees = \App\Models\Employee::orderBy('name', 'asc')->get();

        // ==========================================
        // 2. HITUNG PROGRESS DARI SERVICE (SINGLE SOURCE OF TRUTH)
        // ==========================================

        // -- A. PROGRESS GROUND --
        // (Tetap menggunakan hitungan titik karena di Service belum ada fungsi persentase Ground)
        $groundProgress = 0;
        if ($project->groundReport && $project->groundReport->points->count() > 0) {
            $totalTitik = $project->groundReport->points->count();
            $installed  = $project->groundReport->points->where('install_status', true)->count();
            $measured   = $project->groundReport->points->where('measure_status', true)->count();
            $processed  = $project->groundReport->points->where('process_status', true)->count();

            $groundProgress = (( ($installed/$totalTitik) + ($measured/$totalTitik) + ($processed/$totalTitik) ) / 3) * 100;
        }

        // -- B. PROGRESS UAV --
        $uavProgress = 0;
        if ($project->uavReport) {
            // Gunakan Service yang membagi Luas Tercapai / Luas Proyek
            $uavData = \App\Services\ProgressCalculatorService::calculateUavProgress($project, $project->uavReport);
            $uavProgress = $uavData['persentase'];
        }

        // -- C. PROGRESS FOTO UDARA --
        $photoProgress = 0;
        if ($project->photoReport) {
            $photoProgress = \App\Services\ProgressCalculatorService::calculatePhotoReportOverallProgress($project->photoReport);
        }

        // -- D. PROGRESS LIDAR --
        $lidarProgress = 0;
        if ($project->lidarReport) {
            $lidarProgress = \App\Services\ProgressCalculatorService::calculateLidarReportOverallProgress($project->lidarReport);
        }

        // Batasi nilai maksimal 100%
        $groundProgress = min($groundProgress, 100);
        $uavProgress    = min($uavProgress, 100);
        $photoProgress  = min($photoProgress, 100);
        $lidarProgress  = min($lidarProgress, 100);

        // ==========================================
        // 3. HITUNG RATA-RATA TOTAL KESELURUHAN PROYEK
        // ==========================================
        $totalProjectProgress = ($groundProgress + $uavProgress + $photoProgress + $lidarProgress) / 4;

        return view('projects.show', compact(
            'project', 'employees', 'totalProjectProgress',
            'groundProgress', 'uavProgress', 'photoProgress', 'lidarProgress'
        ));
    }
    // --- FUNGSI TAMBAH PERSONIL ---
    public function storePersonnel(Request $request, Project $project)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'role' => 'required|string'
        ]);

        // Menyimpan data ke tabel pivot (employee_project) beserta rolenya
        $project->personnel()->attach($request->employee_id, ['role' => $request->role]);

        return back()->with('success', 'Personil berhasil ditambahkan ke proyek.');
    }
    // --- FUNGSI HAPUS PERSONIL ---
    public function destroyPersonnel(Project $project, $employee_id, $role)
    {
        // Menghapus spesifik karyawan dengan role tertentu di proyek ini
        \Illuminate\Support\Facades\DB::table('project_personnel')
            ->where('project_id', $project->id)
            ->where('employee_id', $employee_id)
            ->where('role', $role)
            ->delete();

        return back()->with('success', 'Personil berhasil dihapus dari proyek.');
    }
    // --- FUNGSI MENAMPILKAN FORM EDIT ---
    public function edit(Project $project)
    {
        $uavs = \App\Models\AssetUav::all();
        $cameras = \App\Models\AssetCamera::all();
        $pcs = \App\Models\AssetPc::all();
        $gps_units = \App\Models\AssetGps::all();
        return view('projects.edit', compact('project','uavs', 'cameras', 'pcs', 'gps_units'));
    }

    // --- FUNGSI MENYIMPAN PERUBAHAN EDIT ---
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            // PENTING: Untuk validasi unique 'code' saat update, kita harus mengecualikan ID proyek ini sendiri
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

            // Validasi format array untuk daftar alat (Bukan lagi integer tunggal!)
            'planned_uavs' => 'nullable|array',
            'planned_cameras' => 'nullable|array',
            'planned_gps' => 'nullable|array',
            'planned_pcs' => 'nullable|array',
            
            // Validasi format array untuk daftar spesifikasi dan produk
            'products' => 'nullable|array',
            'product_specs' => 'nullable|array',
            'point_codes' => 'nullable|array',
            'tie_points' => 'nullable|array',
        ]);

        // 1. Fungsi pembersih untuk Array Alat (menghapus baris yang ID alat-nya kosong)
        $cleanDeviceArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items, function ($item) {
                return !empty($item['id']); 
            }));
        };

        // 2. Fungsi pembersih untuk Array Teks Biasa (menghapus baris input string yang kosong)
        $cleanTextArray = function ($items) {
            if (!is_array($items)) return null;
            return array_values(array_filter($items)); 
        };

        // Bersihkan data Alat
        $validated['planned_uavs'] = $cleanDeviceArray($request->planned_uavs);
        $validated['planned_cameras'] = $cleanDeviceArray($request->planned_cameras);
        $validated['planned_gps'] = $cleanDeviceArray($request->planned_gps);
        $validated['planned_pcs'] = $cleanDeviceArray($request->planned_pcs);

        // Bersihkan data Detail Persiapan Proyek
        $validated['products'] = $cleanTextArray($request->products);
        $validated['product_specs'] = $cleanTextArray($request->product_specs);
        $validated['point_codes'] = $cleanTextArray($request->point_codes);
        $validated['tie_points'] = $cleanTextArray($request->tie_points);

        // Lakukan pembaruan (Update) ke database
        $project->update($validated);

        return redirect()->route('projects.show', $project->id)->with('success', 'Detail proyek berhasil diperbarui!');
    }

    // --- FUNGSI MENGHAPUS PROYEK ---
    public function destroy(Project $project)
    {
        // Karena di database kita pakai onDelete('cascade'),
        // menghapus proyek akan otomatis menghapus semua data Progress, QC, dan Personil terkait.
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyek beserta seluruh datanya berhasil dihapus!');
    }
    // ... method lain (show, edit, update, destroy) kita isi nanti ...
}
