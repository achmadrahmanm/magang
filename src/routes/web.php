<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return phpinfo();
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/sysadmin', [AuthController::class, 'sysadminDashboard'])->name('dashboard.sysadmin');
    Route::get('/dashboard/mahasiswa', [AuthController::class, 'mahasiswaDashboard'])->name('dashboard.mahasiswa');
    Route::get('/dashboard/dosen', [AuthController::class, 'dosenDashboard'])->name('dashboard.dosen');
    Route::get('/dashboard/management', [AuthController::class, 'managementDashboard'])->name('dashboard.management');

    // Mahasiswa specific routes
    Route::get('/mahasiswa/courses', [AuthController::class, 'mahasiswaCourses'])->name('mahasiswa.courses');
    Route::get('/mahasiswa/grades', [AuthController::class, 'mahasiswaGrades'])->name('mahasiswa.grades');
    Route::get('/mahasiswa/schedule', [AuthController::class, 'mahasiswaSchedule'])->name('mahasiswa.schedule');
    Route::get('/mahasiswa/assignments', [AuthController::class, 'mahasiswaAssignments'])->name('mahasiswa.assignments');
    Route::get('/mahasiswa/settings', [AuthController::class, 'mahasiswaSettings'])->name('mahasiswa.settings');
    Route::get('/mahasiswa/profile', [AuthController::class, 'mahasiswaProfile'])->name('mahasiswa.profile');
});
