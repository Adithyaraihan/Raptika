<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartJabarController;
use App\Http\Controllers\SadajabarController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('smartjabar')->name('smartjabar.')->group(function () {

    // Joined Apps
    Route::get('/joined-apps',              [SmartJabarController::class, 'index'])->name('joined-apps.index');
    Route::get('/joined-apps/create',       [SmartJabarController::class, 'create'])->name('joined-apps.create');
    Route::post('/joined-apps',             [SmartJabarController::class, 'store'])->name('joined-apps.store');
    Route::get('/joined-apps/{id}/edit',    [SmartJabarController::class, 'edit'])->name('joined-apps.edit');
    Route::put('/joined-apps/{id}',         [SmartJabarController::class, 'update'])->name('joined-apps.update');
    Route::delete('/joined-apps/{id}',      [SmartJabarController::class, 'destroy'])->name('joined-apps.destroy');
    // Stats    
    Route::get('/stats/create', [SmartJabarController::class, 'createStat'])->name('stats.create');
    Route::post('/stats', [SmartJabarController::class, 'storeStat'])->name('stats.store');
    Route::get('/stats/{id}/edit', [SmartJabarController::class, 'editStat'])->name('stats.edit');
    Route::put('/stats/{id}', [SmartJabarController::class, 'updateStat'])->name('stats.update');
    Route::delete('/stats/{id}', [SmartJabarController::class, 'destroyStat'])->name('stats.destroy');
});

Route::prefix('sadajabar')->name('sadajabar.')->group(function () {

    // Index gabungan (enkripsi + integrasi dalam satu halaman)
    Route::get('/', [SadajabarController::class, 'index'])->name('index');
    

    // Integrasi Aplikasi (tanpa index sendiri)
    Route::get('/integrasi/create',     [SadajabarController::class, 'integrasiCreate'])->name('integrasi.create');
    Route::post('/integrasi',           [SadajabarController::class, 'integrasiStore'])->name('integrasi.store');
    Route::get('/integrasi/{id}/edit',  [SadajabarController::class, 'integrasiEdit'])->name('integrasi.edit');
    Route::put('/integrasi/{id}',       [SadajabarController::class, 'integrasiUpdate'])->name('integrasi.update');
    Route::delete('/integrasi/{id}',    [SadajabarController::class, 'integrasiDestroy'])->name('integrasi.destroy');

    // Enkripsi Stats (tanpa index sendiri)
    Route::get('/enkripsi/create',      [SadajabarController::class, 'enkripsiCreate'])->name('enkripsi.create');
    Route::post('/enkripsi',            [SadajabarController::class, 'enkripsiStore'])->name('enkripsi.store');
    Route::get('/enkripsi/{id}/edit',   [SadajabarController::class, 'enkripsiEdit'])->name('enkripsi.edit');
    Route::put('/enkripsi/{id}',        [SadajabarController::class, 'enkripsiUpdate'])->name('enkripsi.update');
    Route::delete('/enkripsi/{id}',     [SadajabarController::class, 'enkripsiDestroy'])->name('enkripsi.destroy');
    
});


require __DIR__ . '/auth.php';
