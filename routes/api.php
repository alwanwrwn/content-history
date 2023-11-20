<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;

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

Route::get('/content', [ContentController::class, 'index']);
Route::post('/content', [ContentController::class, 'store']);
Route::get('/content/{content}', [ContentController::class, 'show']);
Route::put('/content/{content}', [ContentController::class, 'update']);
Route::delete('/content/{content}', [ContentController::class, 'destroy']);