<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\SubscriptionController;

// ==================== RUTAS PÚBLICAS ====================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== RUTAS PARA CANDIDATOS ====================
Route::prefix('candidate')->group(function () {
    Route::get('/register', [CandidateController::class, 'showRegistrationForm'])->name('candidate.register');
    Route::post('/register', [CandidateController::class, 'storeRegistration'])->name('candidate.register.submit');
    Route::get('/success', [CandidateController::class, 'success'])->name('candidate.success');
});

// ==================== AUTENTICACIÓN BREEZE ====================
require __DIR__.'/auth.php';

// ==================== RUTAS PROTEGIDAS ====================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');
    
    // Perfil de usuario de Breeze
    Route::view('/profile', 'profile.edit')->name('profile.edit');
 // ==================== RUTAS PARA ENTREVISTADORES ====================
Route::prefix('interviewer')->group(function () {
    // Lista de candidatos (página tradicional)
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    
    // Ver perfil de candidato
    Route::get('/candidate/{candidate}', [CandidateProfileController::class, 'show'])->name('candidate.show');
});

    // ==================== RUTAS PARA ADMINISTRADORES ====================
    Route::prefix('admin')->group(function () {
        // Gestión de suscripciones
        Route::get('/pending-requests', [SubscriptionController::class, 'pendingRequests'])->name('admin.pending-requests');
        Route::get('/candidate/{candidate}/approval', [SubscriptionController::class, 'showApprovalForm'])->name('admin.candidate-approval');
        Route::post('/candidate/{candidate}/approve', [SubscriptionController::class, 'approveCandidate'])->name('admin.approve-candidate');
        Route::get('/active-candidates', [SubscriptionController::class, 'activeCandidates'])->name('admin.active-candidates');
        Route::get('/candidate/{candidate}/subscriptions', [SubscriptionController::class, 'subscriptionHistory'])->name('admin.subscription-history');
        Route::post('/subscription/{subscription}/deactivate', [SubscriptionController::class, 'deactivateSubscription'])->name('admin.deactivate-subscription');
    });
});