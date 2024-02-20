<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->group(function () {
    Route::prefix('author')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::prefix('admin')->group(function () {
        Route::post('/login', [AuthController::class, 'adminLogin']);
        Route::post('/register', [AuthController::class, 'adminRegister']);
    });
});

Route::prefix('article')->group(function () {
    Route::get('', [ArticleController::class, 'index']);
    Route::post('{article_id}/comment', [CommentController::class, 'create']);
});

Route::prefix('comment')->group(function () {
    Route::get('{article_id}', [CommentController::class, 'index']);
});
