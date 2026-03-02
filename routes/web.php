<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- MENU MANAJEMEN ASSET & KARYAWAN (HANYA ADMIN) ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/management', [\App\Http\Controllers\AssetManagementController::class, 'index'])->name('management.index');

    // Karyawan
    Route::post('/management/employee', [\App\Http\Controllers\AssetManagementController::class, 'storeEmployee'])->name('management.employee.store');
    Route::delete('/management/employee/{employee}', [\App\Http\Controllers\AssetManagementController::class, 'destroyEmployee'])->name('management.employee.destroy');

    // UAV
    Route::post('/management/uav', [\App\Http\Controllers\AssetManagementController::class, 'storeUav'])->name('management.uav.store');
    Route::delete('/management/uav/{uav}', [\App\Http\Controllers\AssetManagementController::class, 'destroyUav'])->name('management.uav.destroy');

    // Kamera
    Route::post('/management/camera', [\App\Http\Controllers\AssetManagementController::class, 'storeCamera'])->name('management.camera.store');
    Route::delete('/management/camera/{camera}', [\App\Http\Controllers\AssetManagementController::class, 'destroyCamera'])->name('management.camera.destroy');

    // PC
    Route::post('/management/pc', [\App\Http\Controllers\AssetManagementController::class, 'storePc'])->name('management.pc.store');
    Route::delete('/management/pc/{pc}', [\App\Http\Controllers\AssetManagementController::class, 'destroyPc'])->name('management.pc.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Manajemen Proyek
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);

    // Route Khusus Tracking Progress Induk
    Route::get('/projects/{project}/progress', [\App\Http\Controllers\ProjectProgressController::class, 'index'])
        ->name('projects.progress.index');

    // Route Personil Proyek
    Route::post('/projects/{project}/personnel', [\App\Http\Controllers\ProjectController::class, 'storePersonnel'])->name('projects.personnel.store');
    Route::delete('/projects/{project}/personnel/{employee_id}/{role}', [\App\Http\Controllers\ProjectController::class, 'destroyPersonnel'])->name('projects.personnel.destroy');


    // --- ROUTE LAPORAN GROUND ---
    Route::get('/projects/{project}/ground-report', [\App\Http\Controllers\GroundReportController::class, 'index'])
        ->name('projects.ground.index');
    Route::put('/ground-reports/{report}', [\App\Http\Controllers\GroundReportController::class, 'update'])
        ->name('ground-reports.update');

    // Titik Ground
    Route::post('/ground-reports/{report}/points', [\App\Http\Controllers\GroundPointController::class, 'store'])
        ->name('ground-points.store');
    Route::delete('/ground-points/{point}', [\App\Http\Controllers\GroundPointController::class, 'destroy'])
        ->name('ground-points.destroy');
    Route::get('/ground-points/{point}/edit', [\App\Http\Controllers\GroundPointController::class, 'edit'])
        ->name('ground-points.edit');
    Route::put('/ground-points/{point}', [\App\Http\Controllers\GroundPointController::class, 'update'])
        ->name('ground-points.update');


    // --- ROUTE LAPORAN UAV ---
    Route::get('/projects/{project}/uav-report', [\App\Http\Controllers\UavReportController::class, 'index'])
        ->name('projects.uav.index');
    Route::put('/uav-reports/{report}', [\App\Http\Controllers\UavReportController::class, 'update'])
        ->name('uav-reports.update');

    // Log UAV
    Route::post('/uav-reports/{report}/logs', [\App\Http\Controllers\UavReportController::class, 'storeLog'])
        ->name('uav-logs.store');
    Route::delete('/uav-logs/{log}', [\App\Http\Controllers\UavReportController::class, 'destroyLog'])
        ->name('uav-logs.destroy');


    // --- ROUTE FOTO UDARA ---
    Route::get('/projects/{project}/photo-report', [\App\Http\Controllers\PhotoReportController::class, 'index'])
        ->name('projects.photo.index');
    Route::put('/photo-reports/{report}', [\App\Http\Controllers\PhotoReportController::class, 'updateReport'])
        ->name('photo-reports.update');

    // Hamparan Foto
    Route::post('/photo-reports/{report}/hamparans', [\App\Http\Controllers\PhotoReportController::class, 'storeHamparan'])
        ->name('photo-hamparans.store');
    Route::delete('/photo-hamparans/{hamparan}', [\App\Http\Controllers\PhotoReportController::class, 'destroyHamparan'])
        ->name('photo-hamparans.destroy');
    Route::get('/photo-hamparans/{hamparan}', [\App\Http\Controllers\PhotoReportController::class, 'showHamparan'])
        ->name('photo-hamparans.show');

    // Progress Foto
    Route::post('/photo-hamparans/{hamparan}/progress', [\App\Http\Controllers\PhotoReportController::class, 'storeProgress'])
        ->name('photo-progress.store');
    Route::delete('/photo-progress/{progress}', [\App\Http\Controllers\PhotoReportController::class, 'destroyProgress'])
        ->name('photo-progress.destroy');
    Route::put('/projects/progress/photo/progress/{progress}', [\App\Http\Controllers\PhotoReportController::class, 'updateProgress'])
    ->name('photo-progress.update');

    // Output Foto
    Route::post('/photo-reports/{report}/outputs', [\App\Http\Controllers\PhotoReportController::class, 'storeOutput'])
        ->name('photo-outputs.store');
    Route::delete('/photo-outputs/{output}', [\App\Http\Controllers\PhotoReportController::class, 'destroyOutput'])
        ->name('photo-outputs.destroy');
    // --> TAMBAHAN BARU UNTUK MODAL UPDATE OUTPUT FOTO <--
    Route::put('/projects/progress/photo/outputs/{output}', [\App\Http\Controllers\PhotoReportController::class, 'updateOutput'])
        ->name('photo-outputs.update');


    // --- ROUTE LIDAR ---
    Route::get('/projects/{project}/lidar-report', [\App\Http\Controllers\LidarReportController::class, 'index'])->name('projects.lidar.index');
    Route::put('/lidar-reports/{report}', [\App\Http\Controllers\LidarReportController::class, 'updateReport'])->name('lidar-reports.update');

    // Hamparan Lidar
    Route::post('/lidar-reports/{report}/hamparans', [\App\Http\Controllers\LidarReportController::class, 'storeHamparan'])->name('lidar-hamparans.store');
    Route::delete('/lidar-hamparans/{hamparan}', [\App\Http\Controllers\LidarReportController::class, 'destroyHamparan'])->name('lidar-hamparans.destroy');
    Route::get('/lidar-hamparans/{hamparan}', [\App\Http\Controllers\LidarReportController::class, 'showHamparan'])->name('lidar-hamparans.show');

    // Progress Lidar
    Route::post('/lidar-hamparans/{hamparan}/progress', [\App\Http\Controllers\LidarReportController::class, 'storeProgress'])->name('lidar-progress.store');
    Route::delete('/lidar-progress/{progress}', [\App\Http\Controllers\LidarReportController::class, 'destroyProgress'])->name('lidar-progress.destroy');

    // Output Lidar
    Route::post('/lidar-reports/{report}/outputs', [\App\Http\Controllers\LidarReportController::class, 'storeOutput'])->name('lidar-outputs.store');
    Route::delete('/lidar-outputs/{output}', [\App\Http\Controllers\LidarReportController::class, 'destroyOutput'])->name('lidar-outputs.destroy');


    // --- ROUTE MENU QC (QUALITY CONTROL) ---
    Route::get('/projects/{project}/qc', [\App\Http\Controllers\ProjectQcController::class, 'index'])->name('projects.qc.index');

    Route::get('/projects/{project}/qc-ground', [\App\Http\Controllers\ProjectQcController::class, 'showGround'])->name('projects.qc.ground');
    Route::post('/projects/{project}/qc-ground', [\App\Http\Controllers\ProjectQcController::class, 'updateGround'])->name('projects.qc.ground.update');

    Route::get('/projects/{project}/qc-uav-photo', [\App\Http\Controllers\ProjectQcController::class, 'showUavPhoto'])->name('projects.qc.uav_photo');
    Route::post('/projects/{project}/qc-uav-photo', [\App\Http\Controllers\ProjectQcController::class, 'updateUavPhoto'])->name('projects.qc.uav_photo.update');

    Route::get('/projects/{project}/qc-uav-lidar', [\App\Http\Controllers\ProjectQcController::class, 'showUavLidar'])->name('projects.qc.uav_lidar');
    Route::post('/projects/{project}/qc-uav-lidar', [\App\Http\Controllers\ProjectQcController::class, 'updateUavLidar'])->name('projects.qc.uav_lidar.update');

    Route::get('/projects/{project}/qc-processing', [\App\Http\Controllers\ProjectQcController::class, 'showProcessing'])->name('projects.qc.processing');
    Route::post('/projects/{project}/qc-processing', [\App\Http\Controllers\ProjectQcController::class, 'updateProcessing'])->name('projects.qc.processing.update');

    Route::get('/projects/{project}/qc-manager', [\App\Http\Controllers\ProjectQcController::class, 'showManager'])->name('projects.qc.manager');
    Route::post('/projects/{project}/qc-manager', [\App\Http\Controllers\ProjectQcController::class, 'updateManager'])->name('projects.qc.manager.update');

});

require __DIR__.'/auth.php';
