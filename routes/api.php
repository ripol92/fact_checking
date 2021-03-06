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
    Route::post("update_personal_info", "AuthController@updatePersonalInfo");
});

$androidAppRoutes = [
    "middleware" => ["auth:sanctum"],
    "namespace" => "Api",
    "prefix" => "/users"
];
Route::group($androidAppRoutes, function () {
    Route::post("/create", "UserController@store");
});

$newsGroup = [
    "middleware" => ["auth:api"],
    "namespace" => "Api",
    "prefix" => "/news"
];

Route::group($newsGroup, function () {
    Route::get("/all", "FeedController@getNews");
    Route::get("/fact-check/all", "FeedController@getFactCheckTjNews");
    Route::post("/add-to-favorites", "FeedController@likeItem");
    Route::post("/delete-from-favorites", "FeedController@dislikeItem");
    Route::get("/favorites", "FeedController@getUserLikedNews");
    Route::post("/add-to-analyzed", "FeedController@analyzeItem");
    Route::get("/analyzed", "FeedController@getUserAnalyzedNews");
});

$notificationsGroup = [
    "middleware" => ["auth:api"],
    "namespace" => "Api",
    "prefix" => "/notifications"
];

Route::group($notificationsGroup, function () {
    Route::get("/all", "NotificationsController@all");
});


$feedbackGroup = [
    "middleware" => ["auth:api"],
    "namespace" => "Api",
    "prefix" => "/feedbacks"
];

Route::group($feedbackGroup, function () {
   Route::post("/send-feedback", "FeedbackController@sendFeedback");
});
