<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Project\LikeController;
use App\Http\Controllers\Project\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Project\ChapterController;
use App\Http\Controllers\Project\CommentController;
use App\Http\Controllers\Project\HistoryController;
use App\Http\Controllers\Project\CategoryController;
use App\Http\Controllers\Project\CommunityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Authentification */
Route::post('/authentication/register', [RegisterController::class, 'register']);

Route::post('/authentication/login', [LoginController::class, 'login']);

/**Users */
Route::get('/users', [UserController::class, 'index'])->middleware('auth:api');

Route::get('/user/{user}', [UserController::class, 'show'])->middleware('auth:api');

Route::put('/user/{user}', [UserController::class, 'update'])->middleware('auth:api');

Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware('auth:api');


/** Histories */
Route::get('/histories', [HistoryController::class, 'index'])->middleware('auth:api');

Route::post('/history', [HistoryController::class, 'store'])->middleware('auth:api');

Route::get('/history/{history}', [HistoryController::class, 'show'])->middleware('auth:api');

Route::put('/history/{history}', [HistoryController::class, 'update'])->middleware('auth:api');

Route::delete('/history/{history}', [HistoryController::class, 'destroy'])->middleware('auth:api');


/** Chapters */
Route::get('/history/{history}/chapters', [ChapterController::class, 'index'])->middleware('auth:api');

Route::post('/chapter', [ChapterController::class, 'store'])->middleware('auth:api');

Route::get('/chapter/{chapter}', [ChapterController::class, 'show'])->middleware('auth:api');

Route::put('/chapter/{chapter}', [ChapterController::class, 'update'])->middleware('auth:api');

Route::delete('/chapter/{chapter}', [ChapterController::class, 'destroy'])->middleware('auth:api');

/** Categories */

Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:api');

Route::post('/category', [CategoryController::class, 'store'])->middleware('auth:api');

Route::get('/category/{category}', [CategoryController::class, 'show'])->middleware('auth:api');

Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('auth:api');

Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('auth:api');

/** Comment */

Route::get('/history/{history}/comments', [CommentController::class, 'index'])->middleware('auth:api');

Route::post('/comment', [CommentController::class, 'store'])->middleware('auth:api');

Route::get('/comment/{comment}', [CommentController::class, 'show'])->middleware('auth:api');

Route::put('/comment/{comment}', [CommentController::class, 'update'])->middleware('auth:api');

Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->middleware('auth:api');

/** Likes */

Route::get('/history/{history}/likes', [LikeController::class, 'index'])->middleware('auth:api');

Route::post('/like', [LikeController::class, 'store'])->middleware('auth:api');

Route::get('/like/{like}', [LikeController::class, 'show'])->middleware('auth:api');

Route::delete('/like/{like}', [LikeController::class, 'destroy'])->middleware('auth:api');


/** Forum */

Route::get('/forum/messages', [CommunityController::class, 'index'])->middleware('auth:api');

Route::post('/forum/message', [CommunityController::class, 'store'])->middleware('auth:api');

Route::get('/forum/message/{community}', [CommunityController::class, 'show'])->middleware('auth:api');

Route::put('/forum/message/{community}', [CommunityController::class, 'update'])->middleware('auth:api');

Route::delete('/forum/message/{community}', [CommunityController::class, 'destroy'])->middleware('auth:api');