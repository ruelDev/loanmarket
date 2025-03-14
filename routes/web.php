<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CompareLendersController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ROSController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ROSController as AdminROSController;
use App\Http\Controllers\Admin\BrokersController as AdminBrokersController;
use App\Http\Controllers\Admin\LendersController as AdminLendersController;
use App\Http\Controllers\Admin\ClientsController as AdminClientsController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UtilityController;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/logout', [DashboardController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/real-state-offices', [AdminROSController::class, 'index'])->name('admin.ros');
    Route::post('/admin/real-state-offices/store', [AdminROSController::class, 'store'])->name('admin.rso.store');
    Route::post('/admin/brokers/store', [AdminBrokersController::class, 'store'])->name('admin.brokers.store');
    Route::post('/admin/brokers/delete', [AdminBrokersController::class, 'delete'])->name('admin.brokers.delete');
    Route::get('/admin/brokers', [AdminBrokersController::class, 'index'])->name('admin.brokers');
    Route::get('/admin/utility/lenders-option', [UtilityController::class, 'lendersOption'])->name('admin.utility.lenders.option');
    Route::get('/admin/utility/ros-option', [UtilityController::class, 'rosOption'])->name('admin.utility.ros.option');
    Route::post('/admin/lenders/store', [AdminLendersController::class, 'store'])->name('admin.lenders.store');
    Route::post('/admin/lenders/delete', [AdminLendersController::class, 'delete'])->name('admin.lenders.delete');
    Route::get('/admin/lenders/list', [AdminLendersController::class, 'index'])->name('admin.lenders.list');
    Route::get('/admin/lenders/rates/fixed', [AdminLendersController::class, 'rates'])->name('admin.lenders.rates');
    Route::get('/admin/lenders/rates/variable', [AdminLendersController::class, 'ratesVariable'])->name('admin.lenders.rates.variable');
    Route::get('/admin/clients/lenders', [AdminClientsController::class, 'lenders'])->name('admin.clients.lenders');
    Route::get('/admin/clients', [AdminClientsController::class, 'index'])->name('admin.clients');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::post('/clients/details', [ClientController::class, 'store'])->name('clients.details.store');
Route::post('/request-email-rso', [EmailController::class, 'requestEmailRSO'])->name('request.email.rso');
Route::post('/request-email', [EmailController::class, 'requestEmail'])->name('request.email');
Route::post('/become-partner-email', [EmailController::class, 'becomePartnerEmail'])->name('become-partner.email');
Route::post('/feedback-email', [EmailController::class, 'feedbackEmail'])->name('feedback.email');
Route::get('/compare-loans', [CompareLendersController::class, 'index']);
Route::post('/calculate-savings', [CalculatorController::class, 'calculateSavings'])->name('calculate-savings');
Route::get('/calculate-savings', [CalculatorController::class, 'calculateSavingsDefault'])->name('calculate-savings-default');
Route::get('/{name}', [CalculatorController::class, 'index'])->name('rso');
// Route::get('/{id}', [ROSController::class, 'index'])->name('ros');
Route::get('/', [MainController::class, 'index'])->name('home');

