<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAttachmentController;
use App\Http\Controllers\TaskCommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.verify')->group(function (){
    Route::apiResource('tasks', TaskController::class)->parameters([
        'tasks' => 'id',
    ]);
    Route::apiResource('comments', TaskCommentController::class)->only(['store', 'update', 'destroy'])->parameters([
        'comments' => 'id',
    ]);
    Route::post('tasks/{id}/attachments', [TaskAttachmentController::class, 'upload']);
    Route::get('attachments/{id}/download', [TaskAttachmentController::class, 'download']);
    Route::delete('attachments/{id}', [TaskAttachmentController::class, 'delete']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/me', [AuthController::class, 'userProfile']);