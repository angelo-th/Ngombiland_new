<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\CrowdfundingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RentalDistributionController;
use App\Http\Controllers\SecondaryMarketController;
use App\Http\Controllers\PaymentController;
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
    Route::get('/agent/dashboard', [DashboardController::class, 'agentDashboard'])->name('agent.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])->name('wallet.topup.form');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::get('/wallet/withdraw', [WalletController::class, 'showWithdrawForm'])->name('wallet.withdraw.form');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    // Messages Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/create/{property}', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/{property}', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');

    // Favorites Routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{property}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Investments Routes
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');

    // Properties Routes (authentifiés)
    Route::resource('properties', PropertyController::class)->except(['index', 'show']);
    Route::get('/properties/{property}/crowdfunding/create', [PropertyController::class, 'createCrowdfunding'])->name('properties.crowdfunding.create');
    Route::post('properties/{id}/upload-documents', [PropertyController::class, 'uploadDocuments'])->name('properties.upload');
    Route::get('/properties/create/wizard', function() { return view('properties.wizard'); })->name('properties.wizard');

    // Investments Routes
    Route::get('/investments', [App\Http\Controllers\Crowdfunding\CrowdfundingController::class, 'userInvestments'])->name('investments.index');
    Route::resource('investments', InvestmentController::class)->except(['index']);

    // Crowdfunding Routes
    Route::resource('crowdfunding', CrowdfundingController::class);
    Route::post('/crowdfunding/{crowdfunding}/invest', [CrowdfundingController::class, 'invest'])->name('crowdfunding.invest');
    Route::post('/crowdfunding/{crowdfunding}/activate', [CrowdfundingController::class, 'activate'])->name('crowdfunding.activate');

    // Messages Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Rental Distribution Routes
    Route::get('/rental-distribution', [RentalDistributionController::class, 'index'])->name('rental-distribution.index');
    Route::get('/rental-distribution/{project}', [RentalDistributionController::class, 'show'])->name('rental-distribution.show');
    Route::post('/rental-distribution/{project}/distribute', [RentalDistributionController::class, 'distribute'])->name('rental-distribution.distribute');
    Route::get('/rental-distribution/{project}/estimated-income', [RentalDistributionController::class, 'getEstimatedIncome'])->name('rental-distribution.estimated-income');
    Route::get('/my-rental-income', [RentalDistributionController::class, 'userHistory'])->name('rental-distribution.user-history');

    // Secondary Market Routes
    Route::get('/secondary-market', [SecondaryMarketController::class, 'index'])->name('secondary-market.index');
    Route::get('/secondary-market/create', [SecondaryMarketController::class, 'create'])->name('secondary-market.create');
    Route::post('/secondary-market', [SecondaryMarketController::class, 'store'])->name('secondary-market.store');
    Route::get('/secondary-market/{listing}', [SecondaryMarketController::class, 'show'])->name('secondary-market.show');
    Route::post('/secondary-market/{listing}/offer', [SecondaryMarketController::class, 'makeOffer'])->name('secondary-market.offer');
    Route::post('/secondary-market/offers/{offer}/accept', [SecondaryMarketController::class, 'acceptOffer'])->name('secondary-market.accept-offer');
    Route::post('/secondary-market/offers/{offer}/reject', [SecondaryMarketController::class, 'rejectOffer'])->name('secondary-market.reject-offer');
    Route::get('/my-listings', [SecondaryMarketController::class, 'myListings'])->name('secondary-market.my-listings');
    Route::get('/my-offers', [SecondaryMarketController::class, 'myOffers'])->name('secondary-market.my-offers');
    Route::get('/received-offers', [SecondaryMarketController::class, 'receivedOffers'])->name('secondary-market.received-offers');
    Route::post('/secondary-market/{listing}/cancel', [SecondaryMarketController::class, 'cancelListing'])->name('secondary-market.cancel');

    // Payment Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/topup', [PaymentController::class, 'showTopupForm'])->name('payments.topup');
    Route::post('/payments/topup', [PaymentController::class, 'topup'])->name('payments.topup');
    Route::get('/payments/withdraw', [PaymentController::class, 'showWithdrawForm'])->name('payments.withdraw');
    Route::post('/payments/withdraw', [PaymentController::class, 'withdraw'])->name('payments.withdraw');
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/api/payments/balance', [PaymentController::class, 'getBalance'])->name('payments.balance');
    Route::post('/api/payments/check', [PaymentController::class, 'checkPayment'])->name('payments.check');

    // Secondary Marketplace Routes
    Route::get('/secondary-marketplace', [\App\Http\Controllers\SecondaryMarketplaceController::class, 'index'])->name('secondary-marketplace.index');
    Route::get('/secondary-marketplace/listings/create', [\App\Http\Controllers\SecondaryMarketplaceController::class, 'create'])->name('secondary-marketplace.create');
    Route::post('/secondary-marketplace/listings', [\App\Http\Controllers\SecondaryMarketplaceController::class, 'store'])->name('secondary-marketplace.store');
    Route::get('/secondary-marketplace/listings/{listing}', [\App\Http\Controllers\SecondaryMarketplaceController::class, 'show'])->name('secondary-marketplace.show');
    Route::post('/secondary-marketplace/listings/{listing}/buy', [\App\Http\Controllers\SecondaryMarketplaceController::class, 'buy'])->name('secondary-marketplace.buy');
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
