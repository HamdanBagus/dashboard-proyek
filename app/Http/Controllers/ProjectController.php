<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;



class ProjectController extends Controller
{
    /**
     * Menampilkan daftar proyek.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil data proyek, filter jika ada pencarian, lalu di-paginate
        $projects = Project::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
        })->latest()->paginate(10); // Sesuaikan angka paginate jika perlu

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
        // Load data proyek beserta relasi pivot personilnya
        $project->load('personnel');

        // Ambil semua data master karyawan untuk dropdown
        $employees = Employee::orderBy('name', 'asc')->get();
        // 1. HITUNG PROGRESS GROUND
        $groundProgress = 0;
        $groundReport = \App\Models\GroundReport::with('points')->where('project_id', $project->id)->first();
        if ($groundReport && $groundReport->points->count() > 0) {
            $totalTitik = $groundReport->points->count();
            $installed = $groundReport->points->where('install_status', true)->count();
            $measured = $groundReport->points->where('measure_status', true)->count();
            $processed = $groundReport->points->where('process_status', true)->count();

            $groundProgress = (( ($installed/$totalTitik) + ($measured/$totalTitik) + ($processed/$totalTitik) ) / 3) * 100;
        }

        // 2. HITUNG PROGRESS UAV
        $uavProgress = 0;
        $uavReport = \App\Models\UavReport::with('logs')->where('project_id', $project->id)->first();
        if ($uavReport && $project->area_size > 0) {
            $luasTercapai = $uavReport->logs->where('status', 'Finished Flight')->sum('area_acquired');
            $uavProgress = ($luasTercapai / $project->area_size) * 100;
        }

        // 3. HITUNG PROGRESS FOTO UDARA
        $photoProgress = 0;
        $photoReport = \App\Models\PhotoReport::with(['hamparans.progresses', 'outputs'])->where('project_id', $project->id)->first();
        if ($photoReport) {
            $hamparanProgress = 0;
            $hamparanCount = $photoReport->hamparans->count();
            foreach($photoReport->hamparans as $h) {
                $totalT = $h->progresses->count();
                $selesaiT = $h->progresses->where('status', 'Selesai')->count();
                $hamparanProgress += $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;
            }
            $pctPengolahanFoto = $hamparanCount > 0 ? ($hamparanProgress / $hamparanCount) : 0;

            $totalOut = $photoReport->outputs->count();
            $selesaiOut = $photoReport->outputs->where('checklist', 1)->count();
            $pctOutputFoto = $totalOut > 0 ? ($selesaiOut / $totalOut) * 100 : 0;

            $photoProgress = ($pctPengolahanFoto + $pctOutputFoto) / 2;
        }

        // 4. HITUNG PROGRESS LIDAR
        $lidarProgress = 0;
        $lidarReport = \App\Models\LidarReport::with(['hamparans.progresses', 'outputs'])->where('project_id', $project->id)->first();
        if ($lidarReport) {
            $hamparanProgress = 0;
            $hamparanCount = $lidarReport->hamparans->count();
            foreach($lidarReport->hamparans as $h) {
                $totalT = $h->progresses->count();
                $selesaiT = $h->progresses->where('status', 'Selesai')->count();
                $hamparanProgress += $totalT > 0 ? ($selesaiT / $totalT) * 100 : 0;
            }
            $pctPengolahanLidar = $hamparanCount > 0 ? ($hamparanProgress / $hamparanCount) : 0;

            $totalOut = $lidarReport->outputs->count();
            $selesaiOut = $lidarReport->outputs->where('checklist', 1)->count();
            $pctOutputLidar = $totalOut > 0 ? ($selesaiOut / $totalOut) * 100 : 0;

            $lidarProgress = ($pctPengolahanLidar + $pctOutputLidar) / 2;
        }

        // Batasi nilai maksimal 100% untuk masing-masing
        $groundProgress = min($groundProgress, 100);
        $uavProgress = min($uavProgress, 100);
        $photoProgress = min($photoProgress, 100);
        $lidarProgress = min($lidarProgress, 100);

        // 5. HITUNG RATA-RATA TOTAL KESELURUHAN PROYEK
        $totalProjectProgress = ($groundProgress + $uavProgress + $photoProgress + $lidarProgress) / 4;

        // Load data karyawan untuk modal
        $employees = \App\Models\Employee::all();

        return view('projects.show', compact('project', 'employees', 'totalProjectProgress'));

        // return view('projects.show', compact('project', 'employees'));
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
