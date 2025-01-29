<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CompareLendersController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ROSController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ROSController as AdminROSController;
use App\Http\Controllers\Admin\LendersController as AdminLendersController;
use App\Http\Controllers\Admin\BrokersController as AdminBrokersController;
use App\Http\Controllers\Admin\ClientRecordController as AdminClientRecordController;

// use App\Http\Controllers\Admin\B

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     $data = config('data');
//     return view('welcome', compact('data'));
// });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/real-state-offices', [AdminROSController::class, 'index'])->name('admin.ros');
    Route::get('/admin/brokers', [AdminBrokersController::class, 'index'])->name('admin.brokers');
    Route::get('/admin/lenders', [AdminLendersController::class, 'index'])->name('admin.lenders');
    Route::get('/admin/clients', [AdminClientRecordController::class, 'index'])->name('admin.clients');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::get('/compare-loans', [CompareLendersController::class, 'index']);
Route::get('/', [MainController::class, 'index'])->name('home');

// Wildcard route should always come last
Route::get('/{id}', [ROSController::class, 'index'])->name('ros');
