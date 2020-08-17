<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::to("/nova");
});

Auth::routes([
    "register" => false,
]);

Route::get('/home', function () {
    return Redirect::to("/nova");
});

Route::get("/test", function () {
    $user = \App\User::with([])->findOrFail(1);

    $user->notify(new \App\Notifications\FirebaseNotification([]));
});
