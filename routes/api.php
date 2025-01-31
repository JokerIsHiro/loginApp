<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post("/login", [LoginController::class, "login"]);


Route::prefix('/users')->group(function () {
    Route::get('', [LoginController::class, 'index']);
    Route::get('/{id}', [LoginController::class, 'show'])->middleware('auth:sanctum');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
