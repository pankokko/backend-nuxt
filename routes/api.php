<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

use App\Http\Middleware\Authenticate;

Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::post("/logout", [AuthController::class, 'logout']);

Route::middleware([Authenticate::class])->group(function(){
  Route::get("/user", [AuthController::class, 'user']);
  Route::post("/post", [PostController::class, 'create']);
  Route::post("/product", [PostController::class, 'test']);

  Route::get("/posts", [PostController::class, 'index']);
  Route::get("/post/{id}", [PostController::class, 'show']);
  Route::post("/post/{id}/delete", [PostController::class, 'delete']);
});