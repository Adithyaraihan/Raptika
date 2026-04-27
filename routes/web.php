<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartJabarController;

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
    Route::get('/joined-apps',              [SmartJabarController::class, 'index'])->name('joined-apps.index');
    Route::get('/joined-apps/create',       [SmartJabarController::class, 'create'])->name('joined-apps.create');
    Route::post('/joined-apps',             [SmartJabarController::class, 'store'])->name('joined-apps.store');
    Route::get('/joined-apps/{id}/edit',    [SmartJabarController::class, 'edit'])->name('joined-apps.edit');
    Route::put('/joined-apps/{id}',         [SmartJabarController::class, 'update'])->name('joined-apps.update');
    Route::delete('/joined-apps/{id}',      [SmartJabarController::class, 'destroy'])->name('joined-apps.destroy');
});


require __DIR__ . '/auth.php';
