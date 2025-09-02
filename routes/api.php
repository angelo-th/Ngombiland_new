<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// NGOMBILAND - API for statistics

use App\Http\Controllers\Admin\StatisticsController;

Route::get('/admin/statistics/users', [StatisticsController::class, 'getUserActivity']);
Route::get('/admin/statistics/properties', [StatisticsController::class, 'getPropertyDistribution']);
Route::get('/admin/statistics/transactions', [StatisticsController::class, 'getMonthlyTransactions']);
Route::get('/admin/statistics/investments', [StatisticsController::class, 'getInvestmentTrends']);

// routes/api.php
Route::get('/users', [UserController::class, 'index']); // Liste
Route::post('/users', [UserController::class, 'store']); // Ajouter
Route::put('/users/{id}', [UserController::class, 'update']); // Modifier
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Supprimer
Route::middleware('auth:sanctum')->group(function(){
    Route::post('wallet/topup','WalletController@topup');
    Route::post('wallet/withdraw','WalletController@withdraw');
    Route::get('wallet/balance','WalletController@balance');
});
Route::get('/properties', [PropertyController::class, 'index']); // Liste
Route::post('/properties', [PropertyController::class, 'store']); // Ajouter
Route::put('/properties/{id}', [PropertyController::class, 'update']); // Modifier
Route::delete('/properties/{id}', [PropertyController::class, 'destroy']); // Supprimer
Route::get('/investments', [InvestmentController::class, 'index']); // Liste
Route::post('/investments', [InvestmentController::class, 'store']); // Ajouter
Route::put('/investments/{id}', [InvestmentController::class, 'update']); // Modifier
Route::delete('/investments/{id}', [InvestmentController::class, 'destroy']); // Supprimer
Route::get('/transactions', [TransactionController::class, 'index']); //   
// routes/api.php

use App\Http\Controllers\WalletController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/wallet/top-up', [WalletController::class, 'topUp']);
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);
});
// routes/api.php

use App\Http\Controllers\CrowdfundingController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/crowdfunding/invest', [CrowdfundingController::class, 'invest']);
    Route::get('/crowdfunding/roi/{propertyId}', [CrowdfundingController::class, 'calculateROI']);
    Route::get('/crowdfunding/user/{userId}', [CrowdfundingController::class, 'userInvestments']);
});
// routes/api.php

use App\Http\Controllers\PropertyController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    Route::patch('/properties/{id}/moderate', [PropertyController::class, 'moderate']);
});
// routes/api.php

use App\Http\Controllers\AgentReportController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports', [AgentReportController::class, 'index']);
    Route::post('/reports', [AgentReportController::class, 'store']);
    Route::put('/reports/{id}', [AgentReportController::class, 'update']); // Admin verification
    Route::delete('/reports/{id}', [AgentReportController::class, 'destroy']);
});
// routes/api.php

use App\Http\Controllers\USSDController;

// Public route because USSD request comes from provider
Route::post('/ussd', [USSDController::class, 'handle']);
// routes/api.php

use App\Http\Controllers\ChatController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/{userId}', [ChatController::class, 'fetchMessages']);
});
