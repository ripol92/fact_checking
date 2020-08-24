<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::to("/nova");
});

Auth::routes([
    "register" => false,
]);

Route::get('/runTextRuJobs/{uuid}', 'TextRuController@runJobs');
Route::get('/home', function () {
    return Redirect::to("/nova");
});
