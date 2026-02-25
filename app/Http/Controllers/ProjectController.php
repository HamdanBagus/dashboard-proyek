<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    /**
     * Menampilkan daftar proyek.
     */
    public function index()
    {
        // Ambil data proyek, urutkan dari yang terbaru, 10 per halaman
        $projects = Project::latest()->paginate(10);

        // Kirim data ke view 'projects.index'
        return view('projects.index', compact('projects'));
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
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }
    public function show(Project $project)
    {
        // Kita load relasi personil (nanti akan berguna saat kita sudah isi data)
        // Saat ini tabel personil mungkin masih kosong, tidak apa-apa.
        $project->load('personnel');

        return view('projects.show', compact('project'));
    }

    // ... method lain (show, edit, update, destroy) kita isi nanti ...
}
