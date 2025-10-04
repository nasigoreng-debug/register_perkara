<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\DashboardController;


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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk CRUD Perkara
Route::get('/perkaras', [PerkaraController::class, 'index'])->name('perkaras.index');
Route::get('/perkaras/create', [PerkaraController::class, 'create'])->name('perkaras.create');
Route::post('/perkaras', [PerkaraController::class, 'store'])->name('perkaras.store');
Route::get('/perkaras/{id}', [PerkaraController::class, 'show'])->name('perkaras.show');
Route::get('/perkaras/{id}/edit', [PerkaraController::class, 'edit'])->name('perkaras.edit');
Route::put('/perkaras/{id}', [PerkaraController::class, 'update'])->name('perkaras.update');
Route::delete('/perkaras/{id}', [PerkaraController::class, 'destroy'])->name('perkaras.destroy');

Auth::routes();


