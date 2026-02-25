<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now()->toDateString();

        // Menghitung Statistik
        $totalProyek = Project::count();

        // Asumsi: Jika tanggal selesai masih hari ini atau di masa depan, maka "Sedang Berjalan"
        $proyekBerjalan = Project::whereDate('end_date', '>=', $hariIni)->count();

        // Asumsi: Jika tanggal selesai sudah lewat dari hari ini, maka "Selesai"
        $proyekSelesai = Project::whereDate('end_date', '<', $hariIni)->count();

        // Mengambil 5 proyek terbaru untuk ditampilkan di tabel sekilas
        $proyekTerbaru = Project::latest()->take(5)->get();

        return view('dashboard', compact('totalProyek', 'proyekBerjalan', 'proyekSelesai', 'proyekTerbaru'));
    }
}
