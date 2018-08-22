<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

/**
 * passport client test
 */
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://laravel-passport-client.com/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://laravel-passport.com/oauth/authorize?'.$query);
});

/**
 * passport callback
 */
Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://laravel-passport.com/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 3,
            'client_secret' => 'KQ6XLIJFE73xXDuneqLZeCWEOTo1dyyX7jq5vmA7',
            'redirect_uri' => 'http://laravel-passport-client.com/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
