<?php

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
    return "How to use: /proxy/https://yoursite.com";
});


Route::get('/{any}', function () {
    $request = request();
    $url = 'https://fapi.binance.com/'.$request->path();
    $client = new GuzzleHttp\Client();

    $headers = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36',
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
        // Tambahkan header lain yang diperlukan di sini
    ];
    
    $headers = array_merge($headers);
    
    // dd($headers);
    $options = [
        'headers' => $headers,
        'form_params' => $request->all(),
        'query' => $request->query(),
    ];

    $response = $client->request($request->method(), $url, $options);

    return response($response->getBody()->getContents(), $response->getStatusCode(), $response->getHeaders());
})->where('any', '.*');