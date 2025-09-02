<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Inscription
    Route::post('/register', [AuthController::class, 'register']);
    
    // Connexion
    Route::post('/login', [AuthController::class, 'login']);
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    // Vérification OTP
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    
    // Routes protégées par rôle
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        // Routes admin
    });
    
    Route::middleware(['auth:sanctum', 'role:property_owner'])->group(function () {
        // Routes propriétaires
    });
    
    Route::middleware(['auth:sanctum', 'role:investor'])->group(function () {
        // Routes investisseurs
    });
});