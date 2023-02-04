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


Route::get('/proxy', function () {
    $request = request();
    $url = $request->url;

    $headers = [
        'User-Agent' => 'Your User Agent',
        // Tambahkan header lain yang diperlukan di sini
    ];

    // Mengambil semua header dari request masuk
    $headers = array_merge($headers, $request->headers->all());

    $options = [
        'headers' => $headers,
        'form_params' => $request->all(),
        'query' => $request->query(),
    ];

    $client = new GuzzleHttp\Client();
    $response = $client->request($request->method(), $url, $options);
    
    return response($response->getBody()->getContents(), $response->getStatusCode(), $response->getHeaders());
});