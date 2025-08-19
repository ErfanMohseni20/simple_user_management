<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('register', 'Register');
    Route::post('login', "Login");
});

Route::prefix('manage')->middleware(['auth_user' , 'role:admin'])->controller(\App\Http\Controllers\HomeController::class)->group(function () {
    Route::prefix('permission')->group(function () {
        Route::post('withdraw', 'WithDrawPermission');
        Route::post('refresh', 'RefreshPermissions');
        Route::post('{permission}/has', 'HasPermission');
        Route::post('add', 'AddPermission');
    });
    Route::prefix('role')->group(function () {
        Route::post('add', 'AddRole');
        Route::post('withdraw', 'WithDrawRole');
        Route::post('refresh', 'RefreshRole');
        Route::post('{role}/has', 'HasRole');
    });
});
Route::apiResource('permissions', PermissionController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('users' , UserController::class);