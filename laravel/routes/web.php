<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicController;

// публичная витрина — без авторизации
Route::get('/',          [PublicController::class, 'home'])->name('home');
Route::get('/catalog',   [PublicController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{animal}', [PublicController::class, 'show'])->name('catalog.show');

// после авторизации редирект на дэшборд
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// профиль пользователя (стандартные маршруты Breeze)
Route::middleware('auth')->group(function () {
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:администратор'])->prefix('admin')->group(function () {
    Route::get('/dashboard/export', [DashboardController::class, 'exportSales'])
        ->name('dashboard.export');
    Route::resource('species',   SpeciesController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('employees', EmployeeController::class);
});

Route::middleware(['auth', 'role:администратор,продавец'])->group(function () {
    Route::resource('animals', AnimalController::class);
    Route::patch('animals/{animal}/approve', [AnimalController::class, 'approve'])->name('animals.approve');
    Route::resource('sales', SaleController::class)->except(['edit', 'update']);
    Route::resource('clients', ClientController::class)->except(['show', 'destroy']);
});

Route::middleware(['auth', 'role:ветврач,администратор'])->group(function () {
    Route::resource('vet', VetController::class);
});

require __DIR__.'/auth.php';