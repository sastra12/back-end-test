<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'loginView']);
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/data-employee', [DashboardController::class, 'data'])->name('data-employee');
Route::put('/employee/{id}/update', [DashboardController::class, 'update'])->name('update-employee');
Route::get('/employee/{id}/edit', [DashboardController::class, 'edit'])->name('edit-employee');
Route::post('/employee/store', [DashboardController::class, 'store'])->name('store-employee');
Route::delete('/employee/{id}/delete', [DashboardController::class, 'delete'])->name('delete-employee');
