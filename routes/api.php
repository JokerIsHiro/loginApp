<?php

use App\Http\Controllers\API\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post('/register', [LoginController::class, 'register']);
Route::get("/users", [LoginController::class, "index"]);

Route::middleware("auth:api")->group(function () {
    Route::get("/user/{id}", [LoginController::class, "show"]);
    Route::post('/logout', [LoginController::class, 'logout']);
});
