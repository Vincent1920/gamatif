<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaBaruAuthController;
use App\Http\Controllers\Api\MahasiswaBaruController;

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



Route::post('/register', [MahasiswaBaruAuthController::class, 'register']);
Route::post('/login', [MahasiswaBaruAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [MahasiswaBaruAuthController::class, 'logout']);
    Route::get('/me', [MahasiswaBaruAuthController::class, 'me']);
});


// Route::middleware(['auth', 'check.status'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
// });

