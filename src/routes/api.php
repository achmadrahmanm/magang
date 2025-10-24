<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

// Authentication routes (API)
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Mahasiswa Proposal CRUD (API)
    Route::post('/mahasiswa/proposal', [MahasiswaController::class, 'storeProposal']);
    Route::put('/mahasiswa/proposal/{proposalId}', [MahasiswaController::class, 'updateProposal']);
    Route::get('/mahasiswa/proposals', [MahasiswaController::class, 'getProposals']);
    Route::get('/mahasiswa/proposal/{proposalId}', [MahasiswaController::class, 'showProposal']);
    Route::delete('/mahasiswa/proposal/{proposalId}', [MahasiswaController::class, 'deleteProposal']);
    Route::post('/mahasiswa/proposal/save-draft', [MahasiswaController::class, 'saveDraft']);
    Route::get('/mahasiswa/proposal/load-draft', [MahasiswaController::class, 'loadDraft']);

    // Mahasiswa Signature CRUD (API)
    Route::post('/signature', [MahasiswaController::class, 'saveSignature']);
    Route::get('/signatures', [MahasiswaController::class, 'getUserSignatures']);
    Route::delete('/signature/{signatureId}', [MahasiswaController::class, 'deleteSignature']);
    Route::post('/signature/{signatureId}/set-active', [MahasiswaController::class, 'setActiveSignature']);
    Route::get('/signature/{signatureId}/download', [MahasiswaController::class, 'downloadSignature']);
});
