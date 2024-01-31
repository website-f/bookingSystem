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
Route::get('/get-stylist/{locationId}/{serviceId}', [BookingController::class, 'getStylists']);
Route::get('/get-schedule/{stylistId}', [BookingController::class, 'getSchedule']);
Route::post('/book-appointment', [BookingController::class, 'bookAppointment']);
Route::get('/thankyou/{id}', [BookingController::class, 'thankyou']);
Route::post('/remove-offday', [AdminController::class, 'removeOffday'])->middleware('auth');

Route::prefix('dashboard')->group(function() {
    Route::get('/', [AdminController::class, 'home'])->middleware('auth');
    Route::get('/location', [AdminController::class, 'location'])->middleware('auth');
    Route::post('/add-location', [AdminController::class, 'Addlocation'])->middleware('auth');
    Route::put('/edit-location/{id}', [AdminController::class, 'Editlocation'])->middleware('auth');
    Route::get('/stylist', [AdminController::class, 'stylist'])->middleware('auth');
    Route::post('/add-stylist', [AdminController::class, 'addStylist'])->middleware('auth');
    Route::put('/edit-stylist/{id}', [AdminController::class, 'editStylist'])->middleware('auth');
    Route::get('/remove-stylist/{id}', [AdminController::class, 'removeStylist'])->middleware('auth');
    Route::get('/service', [AdminController::class, 'service'])->middleware('auth');
    Route::post('/add-service', [AdminController::class, 'addService'])->middleware('auth');
    Route::put('/edit-service/{id}', [AdminController::class, 'editService'])->middleware('auth');
    Route::get('/remove-service/{id}', [AdminController::class, 'removeService'])->middleware('auth');
    Route::get('/service-categories', [AdminController::class, 'category'])->middleware('auth');
    Route::post('/add-category', [AdminController::class, 'addCategory'])->middleware('auth');
    Route::put('/edit-category/{id}', [AdminController::class, 'editCategory'])->middleware('auth');
});
