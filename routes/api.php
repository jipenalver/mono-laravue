<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskTagController;
use App\Http\Controllers\Api\TaskActionController;
use App\Http\Controllers\Api\TaskAttachmentController;


// Auth API
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('user.login');
    Route::post('/register', 'register')->name('user.register');
});

Route::middleware(['auth:sanctum'])->group(function () {
    // User API
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth Logout API
    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');

    // Tasks API
    Route::controller(TaskController::class)->group(function () {
        Route::post('/tasks/search/{type?}', 'index');
        Route::get('/tasks/{id}', 'show');
        Route::post('/tasks', 'store');
        Route::put('/tasks/{id}', 'update');
        Route::delete('/tasks/{id}', 'destroy');
    });

    // Tasks Actions API
    Route::controller(TaskActionController::class)->group(function () {
        Route::get('/task/complete/{id}', 'complete');
        Route::get('/task/incomplete/{id}', 'incomplete');
        Route::put('/task/due/{id}', 'due');
        Route::get('/task/archive/{id}', 'archive');
        Route::get('/task/restore/{id}', 'restore');
    });

    // Task Attachments and Tags API
    Route::controller(TaskAttachmentController::class)->group(function () {
        Route::put('/task/attachments/{id}', 'update');
        Route::get('/task/attachments/show/{id}', 'show');
    });
    Route::controller(TaskTagController::class)->group(function () {
        Route::put('/task/tags/{id}', 'update');
        Route::get('/task/tags/show/{id}', 'show');
    });
});
