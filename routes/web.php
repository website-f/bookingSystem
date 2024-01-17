<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;

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

Route::get('/', [BookingController::class, 'home']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-fill', [AuthController::class, 'loginAuth']);
Route::get('/logout', [AuthController::class, "logout"])->middleware('auth');

Route::prefix('dashboard')->group(function() {
    Route::get('/', [AdminController::class, 'home'])->middleware('auth');
    Route::get('/location', [AdminController::class, 'location'])->middleware('auth');
    Route::post('/add-location', [AdminController::class, 'Addlocation'])->middleware('auth');
});
