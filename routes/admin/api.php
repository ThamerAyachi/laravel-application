<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CommentController;
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


Route::get('/profile', [AuthController::class, 'adminProfile']);

Route::prefix("article")->group(function () {
    Route::get('', [ArticleController::class, 'index']);
    Route::post('{article_id}', [ArticleController::class, 'update']);
    Route::delete('{article_id}', [ArticleController::class, 'destroy']);
    Route::post('{article_id}/publish', [ArticleController::class, 'publish']);
    Route::post('{article_id}/unpublish', [ArticleController::class, 'unpublish']);
});

Route::prefix("comment")->group(function () {
    Route::post('{comment_id}', [CommentController::class, 'update']);
    Route::delete('{comment_id}', [CommentController::class, 'destroy']);
});
