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
        return view('projects.create');
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
            'planned_uav' => 'nullable|integer',
            'planned_lidar' => 'nullable|integer',
            'planned_gps' => 'nullable|integer',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }
    public function show(Project $project)
    {
        // Load data proyek beserta relasi pivot personilnya
        $project->load('personnel');

        // Ambil semua data master karyawan untuk dropdown
        $employees = Employee::orderBy('name', 'asc')->get();

        return view('projects.show', compact('project', 'employees'));
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
        return view('projects.edit', compact('project'));
    }

    // --- FUNGSI MENYIMPAN PERUBAHAN EDIT ---
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:projects,code,' . $project->id,
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string',
            'area_size' => 'required|numeric',
            'project_location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'planned_uav' => 'nullable|integer',
            'planned_lidar' => 'nullable|integer',
            'planned_gps' => 'nullable|integer',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Data Proyek berhasil diperbarui!');
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
