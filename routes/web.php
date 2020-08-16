<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

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
    return view('welcome');
});

Auth::routes();

//Route::get('test', function () {
//    $url = "http://api.text.ru/post";
//    $client = new Client(['base_uri' => $url]);
//    $data = [
//        'text' => 'Так, кассовые сборы в 2019 году составили 55,5 миллиарда рублей, рост рынка в текущем году прогнозировали на восемь процентов. Однако закрытие кинотеатров, перенос многих премьер на 2021 год, настороженность зрителей и другие факторы снизили рост показателей.',
//        'userkey' => 'f5499652232c926bf31661b63dead693'
//    ];
//
//    $response = $client->request('POST','',[
//        GuzzleHttp\RequestOptions::FORM_PARAMS => $data
//    ]);
//
//    return $response->getBody()->getContents();
//    /** @var \App\FactChecking\Parser\Services\ArticleParser $service */
//    $service = resolve(\App\FactChecking\Parser\Services\ArticleParser::class);
//    $service->parse("https://vecherka.tj/archives/45898/");
//});

Route::get('publish', function () {
    // Route logic...

    Redis::publish('urls_for_parse', json_encode(['url' => 'https://vecherka.tj/archives/46310', 'lng' => 'ru']));
});

Route::get('/test-text', function () {
    $url = "http://api.text.ru/post";
    $client = new Client(['base_uri' => $url]);
    $data = [
        'uid' => '5f3961bc81a23',
        'userkey' => env('TEXT_RU_KEY')
    ];

    $response = $client->request('POST','',[
        GuzzleHttp\RequestOptions::FORM_PARAMS => $data
    ]);

    return $response->getBody()->getContents();
});


Route::get('/home', 'HomeController@index')->name('home');
