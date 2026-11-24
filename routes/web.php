<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\SoinController;
use Illuminate\Support\Facades\Route;

// ---------- Visiteurs (non connectés)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ---------- Utilisateurs connectés
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin + secrétaire : création, modification, suppression
    // (déclaré AVANT les routes show pour que /patients/create ne soit pas pris pour {patient})
    Route::middleware('role:admin,secretaire')->group(function () {
        Route::resource('patients', PatientController::class)->except(['index', 'show']);
        Route::resource('rendez-vous', RendezVousController::class)
            ->parameters(['rendez-vous' => 'rendez_vous'])
            ->except(['index', 'show']);
    });

    // Tous les rôles : consultation
    Route::resource('patients', PatientController::class)->only(['index', 'show']);
    Route::get('rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');

    // Admin + dentiste : changer le statut d'un rendez-vous
    Route::patch('rendez-vous/{rendez_vous}/statut', [RendezVousController::class, 'changerStatut'])
        ->middleware('role:admin,dentiste')
        ->name('rendez-vous.statut');

    // Admin uniquement : catalogue des soins
    Route::middleware('role:admin')->group(function () {
        Route::resource('soins', SoinController::class)->only(['index', 'store', 'destroy']);
    });
});
