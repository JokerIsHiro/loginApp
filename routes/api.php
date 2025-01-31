<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post("/login",[LoginController::class,"login"]);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('/users', [LoginController::class, 'index']);
    Route::post('/logout', [LoginController::class,'logout']);
});
