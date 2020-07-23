<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$authGroup = [
    "middleware" => ["api"],
    "namespace" => "Api"
];
Route::group($authGroup, function () {
    Route::post("login", "AuthController@login");
    Route::get("me", "AuthController@me");
});

$androidAppRoutes = [
    "middleware" => ["auth:sanctum"],
    "namespace" => "Api",
    "prefix" => "/users"
];
Route::group($androidAppRoutes, function () {
    Route::post("/create", "UserController@store");
    Route::post("/get-feeds", "FeedController@getNews");

});

Route::post("/test", "Api\FeedController@getNews");
