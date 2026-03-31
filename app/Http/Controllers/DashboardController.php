<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunIni = Carbon::now()->year;
        
        // 1. Statistik Keseluruhan (All Time)
        $totalSemuaProyek = Project::count();

        // 2. Statistik Tahun Ini
        $totalProyek = Project::whereYear('start_date', $tahunIni)->count();

        $proyekBerjalan = Project::whereYear('start_date', $tahunIni)
            ->where('status', 'ongoing')
            ->count();

        $proyekSelesai = Project::whereYear('start_date', $tahunIni)
            ->where('status', 'finished')
            ->count();
            
        // 3. 5 Proyek Terbaru
        $proyekTerbaru = Project::latest()->take(5)->get();
        
        // 4. Chart 5 Tahun Terakhir
        $chartData = Project::select(
                DB::raw('YEAR(start_date) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('start_date', '>=', $tahunIni - 4)
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return view('dashboard', compact(
            'totalSemuaProyek',
            'totalProyek',
            'proyekBerjalan',
            'proyekSelesai',
            'proyekTerbaru',
            'chartData'
        ));
    }
}