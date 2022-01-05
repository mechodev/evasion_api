<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Project\UserController;

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


Route::post('/authentication/register', [RegisterController::class, 'register']);

Route::post('/authentication/login', [LoginController::class, 'login']);


Route::get('/users', [UserController::class, 'index']);

Route::get('/user/{id}', [UserController::class, 'show']);

Route::get('/histories', [HistoryController::class, 'index']);

Route::get('/history/{id}', [HistoryController::class, 'show']);

Route::get('/history/{id}/chapters', [ChapterController::class, 'index']);

Route::get('/history/{id}/chapters/{id}', [ChapterController::class, 'show']);
