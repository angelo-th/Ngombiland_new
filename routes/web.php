<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Liste des biens (publique)
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

// Vérification email
Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// ======================= 🖥️ DASHBOARD (AUTHENTIFIÉ) =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])->name('wallet.topup.form');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::get('/wallet/withdraw', [WalletController::class, 'showWithdrawForm'])->name('wallet.withdraw.form');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    // Messages Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/create/{property}', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/{property}', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');

    // Properties Routes (authentifiés)
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::resource('properties', PropertyController::class)->except(['index', 'show']);
    Route::post('properties/{id}/upload-documents', [PropertyController::class, 'uploadDocuments'])->name('properties.upload');

    // Investments Routes
    Route::get('/investments', [App\Http\Controllers\Crowdfunding\CrowdfundingController::class, 'userInvestments'])->name('investments.index');
    Route::resource('investments', InvestmentController::class)->except(['index']);

    // Crowdfunding Routes
    Route::get('/crowdfunding', [App\Http\Controllers\Crowdfunding\CrowdfundingController::class, 'index'])->name('crowdfunding.index');
    Route::post('/crowdfunding/{property}/invest', [App\Http\Controllers\Crowdfunding\CrowdfundingController::class, 'invest'])->name('crowdfunding.invest');

    // Messages Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

// ======================= 👑 ADMIN =======================
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
});

// ======================= 🔄 ROUTES LARAVEL PAR DÉFAUT =======================
Auth::routes(['verify' => true]);
