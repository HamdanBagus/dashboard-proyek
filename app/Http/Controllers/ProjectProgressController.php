<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectProgressController extends Controller
{
    /**
     * Menampilkan Menu Utama Log Progress (4 Kartu)
     */
    public function index(Project $project)
    {
        // Nanti kita akan load data progress di sini (persentase)
        // Sementara kita kirim data project saja
        return view('projects.progress.index', compact('project'));
    }
}
