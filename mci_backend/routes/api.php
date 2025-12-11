<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MediaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ---------------------------------------------
// Public Authentication Routes (No middleware)
// ---------------------------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ---------------------------------------------
// Protected Routes
// ---------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Get logged-in user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Users CRUD for react-admin
    Route::get('/users',        [UserController::class, 'index']);
    Route::get('/users/{id}',   [UserController::class, 'show']);
    Route::post('/users',       [UserController::class, 'store']);
    Route::put('/users/{id}',   [UserController::class, 'update']);
    Route::delete('/users/{id}',[UserController::class, 'destroy']);

    // Roles CRUD
    Route::apiResource('roles', RoleController::class);

    // Posts CRUD (React Admin compatible)
    Route::apiResource('posts', PostController::class);

    // Pages CRUD
    Route::apiResource('pages', PageController::class);

    // Menus CRUD
    Route::apiResource('menus', MenuController::class);

    // Media CRUD
    Route::apiResource('media', MediaController::class);

});
