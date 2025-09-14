<?php

use App\Http\Controllers\Api\SosialMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaBaruAuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\KelompokGeneratorController;
use App\Http\Controllers\Api\PengaturanWebController;


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

Route::get('/pengaturan-web', [PengaturanWebController::class, 'index']);
Route::get('/sosial-media', [SosialMediaController::class, 'index']);


Route::post('/register', [MahasiswaBaruAuthController::class, 'register']);
Route::post('/login', [MahasiswaBaruAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [MahasiswaBaruAuthController::class, 'logout']);
    Route::get('/me', [MahasiswaBaruAuthController::class, 'me']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

    Route::get('/kelompok/status', [KelompokGeneratorController::class, 'getStatus']);
    Route::post('/kelompok/generate', [KelompokGeneratorController::class, 'generate']);

    

});
