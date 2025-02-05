<?php

use App\Http\Controllers\API\LoginController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:api");

Route::post("/login", [LoginController::class, "login"]);
<<<<<<< Updated upstream


Route::prefix('/users')->group(function () {
    Route::get('', [LoginController::class, 'index']);
    Route::get('/{id}', [LoginController::class, 'show'])->middleware('auth:sanctum');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
=======
Route::post('/register', [LoginController::class, 'register']);
Route::get("/users", [LoginController::class, "index"]);

Route::middleware("auth:api")->group(function () {
    Route::get("/user/{id}", [LoginController::class, "show"]);
    Route::post('/logout', [LoginController::class, 'logout']);
});

>>>>>>> Stashed changes
