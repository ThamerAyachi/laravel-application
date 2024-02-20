<?php

use App\Http\Controllers\Author\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/profile', [AuthController::class, 'userProfile']);

Route::prefix('article')->group(function () {
    Route::post('', [ArticleController::class, 'create']);
    Route::post('{article_id}', [ArticleController::class, 'update']);
    Route::delete('{article_id}', [ArticleController::class, 'destroy']);
});
