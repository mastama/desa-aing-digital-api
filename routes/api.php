<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// CRUD users:
Route::apiResource('users', UserController::class);

// -> POST /api/users
// -> GET /api/users/{id}
// -> PUT/PATCH /api/users/{id}
// -> DELETE /api/users/{id}