<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test', function () {
    return phpinfo();
});

// Authentication routes (web only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});
Route::middleware('logout.guard')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
});

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
    Route::get('/mahasiswa/formal-requests', [AuthController::class, 'mahasiswaFormalRequests'])->name('mahasiswa.formal-requests');
    Route::get('/mahasiswa/form-formal-requests', [MahasiswaController::class, 'showFormalRequestForm'])->name('mahasiswa.form-formal-requests');

    Route::get('/mahasiswa/settings', [AuthController::class, 'mahasiswaSettings'])->name('mahasiswa.settings');
    Route::get('/mahasiswa/profile', [AuthController::class, 'mahasiswaProfile'])->name('mahasiswa.profile');

     // Mahasiswa Application routes (formerly Proposal routes)
    Route::post('/mahasiswa/store-proposal', [MahasiswaController::class, 'storeProposal'])->name('mahasiswa.store-proposal');
    Route::post('/mahasiswa/save-draft', [MahasiswaController::class, 'saveDraft'])->name('mahasiswa.save-draft');
    Route::get('/mahasiswa/load-draft', [MahasiswaController::class, 'loadDraft'])->name('mahasiswa.load-draft');
    Route::get('/mahasiswa/proposals', [MahasiswaController::class, 'getProposals'])->name('mahasiswa.get-proposals');
    Route::get('/mahasiswa/proposal/{proposalId}/download', [MahasiswaController::class, 'downloadProposal'])->name('mahasiswa.download-proposal');
    Route::get('/mahasiswa/proposal/{proposalId}/preview', [MahasiswaController::class, 'previewProposal'])->name('mahasiswa.preview-proposal');
    Route::delete('/mahasiswa/proposal/{proposalId}', [MahasiswaController::class, 'deleteProposal'])->name('mahasiswa.delete-proposal');
    Route::get('/mahasiswa/business-fields', [MahasiswaController::class, 'getBusinessFields'])->name('mahasiswa.business-fields');

    // New Application Management routes
    Route::get('/mahasiswa/applications', [MahasiswaController::class, 'getProposals'])->name('mahasiswa.applications');
    Route::get('/mahasiswa/application/{applicationId}/download', [MahasiswaController::class, 'downloadProposal'])->name('mahasiswa.download-application');
    Route::get('/mahasiswa/application/{applicationId}/preview', [MahasiswaController::class, 'previewProposal'])->name('mahasiswa.preview-application');
    Route::delete('/mahasiswa/application/{applicationId}', [MahasiswaController::class, 'deleteProposal'])->name('mahasiswa.delete-application');

    // Mahasiswa Signature routes
    Route::get('/mahasiswa/signature', [MahasiswaController::class, 'showSignaturePage'])->name('mahasiswa.signature');
    Route::post('/mahasiswa/save-signature', [MahasiswaController::class, 'saveSignature'])->name('mahasiswa.save-signature');
    Route::get('/mahasiswa/get-signatures', [MahasiswaController::class, 'getUserSignatures'])->name('mahasiswa.get-signatures');
    Route::delete('/mahasiswa/signature/{signatureId}', [MahasiswaController::class, 'deleteSignature'])->name('mahasiswa.delete-signature');
    Route::post('/mahasiswa/signature/{signatureId}/set-active', [MahasiswaController::class, 'setActiveSignature'])->name('mahasiswa.set-active-signature');
    Route::get('/mahasiswa/signature/{signatureId}/download', [MahasiswaController::class, 'downloadSignature'])->name('mahasiswa.download-signature');


});
