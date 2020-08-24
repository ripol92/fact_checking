<?php

use Illuminate\Support\Facades\Route;

$authGroup = [
    "middleware" => ["api"],
    "namespace" => "Api"
];
Route::group($authGroup, function () {
    Route::post("login", "AuthController@login");
    Route::get("me", "AuthController@me");
    Route::post("update_firebase_token", "AuthController@updateFirebaseToken");
});

$androidAppRoutes = [
    "middleware" => ["auth:sanctum"],
    "namespace" => "Api",
    "prefix" => "/users"
];
Route::group($androidAppRoutes, function () {
    Route::post("/create", "UserController@store");
});
