<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttachmentController;

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

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});
// Task routes
Route::middleware('auth:api')->group(function () {
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/{id}', [TaskController::class, 'get']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('tasks/{id}', [TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
});
// Attachment routes
Route::middleware('auth:api')->group(function () {
    Route::post('tasks/{id}/attachments', [AttachmentController::class, 'upload']);
    Route::get('attachments/{id}/download', [AttachmentController::class, 'download']);
    Route::delete('attachments/{id}', [AttachmentController::class, 'destroy']);
});

