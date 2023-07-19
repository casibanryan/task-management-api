<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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


 Route::post('/login', [UserController::class, 'login']);


Route::prefix('tasks')->middleware('auth:sanctum')->group(function() {
   Route::controller(TaskController::class)->group(function() {
        Route::get('/', 'index');
        Route::post('/update/{task}', [TaskController::class, 'update']);
        Route::get('/{task}', [TaskController::class, 'show']);
        Route::post('/create', [TaskController::class, 'store']);
        Route::delete('/{task}', [TaskController::class, 'destroy']);
   });
  
});