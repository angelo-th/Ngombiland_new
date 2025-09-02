<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================= 🔓 ROUTES PUBLIQUES (VISITEURS) =======================
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/services', [WelcomeController::class, 'services'])->name('services');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');

// Liste des biens
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');

// Messages support visiteurs (max 3 si pas connecté)
Route::post('/support/message', [SupportController::class, 'send'])
    ->middleware('limit.guest.messages')
    ->name('support.message');

// ======================= 🔑 AUTHENTIFICATION =======================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// ======================= 🖥️ DASHBOARD (UNIQUE POUR TOUS) =======================
Route::get('/dashboard', function () {
    return view('dashboard'); // Une seule vue
})->name('dashboard');

// ======================= 🏠 PROPRIÉTÉS =======================
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('properties', PropertyController::class);
    Route::post('properties/{id}/upload-documents', [PropertyController::class, 'uploadDocuments'])->name('properties.upload');
});

// ======================= 👑 ADMIN =======================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('properties', PropertyController::class);
});

// ======================= 🔄 ROUTES LARAVEL PAR DÉFAUT =======================
Auth::routes(['verify' => true]);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');