<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstablishmentController;

Route::get('/ping', function(){
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']); // Feiito
Route::post('/auth/logout', [AuthController::class, 'logout']); // Feiito
Route::post('/auth/refresh', [AuthController::class, 'refresh']); // Feiito

Route::post('/user', [AuthController::class, 'create']); // Feiito
Route::get('/user', [UserController::class, 'read']); // Feiito
Route::put('/user', [UserController::class, 'update']);

Route::post('/establishment/create', [EstablishmentController::class, 'create']); // Feiito
Route::get('/establishment', [EstablishmentController::class, 'list']); // Feiito
Route::get('/establishment/{id}', [EstablishmentController::class, 'one']); // Feiito
Route::put('/establishment/{id}', [EstablishmentController::class, 'update']); // Feiito

// Route::get('/search', [EstablishmentController::class, 'search']);