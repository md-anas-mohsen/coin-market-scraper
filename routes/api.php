<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use Spatie\Browsershot\Browsershot;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/load-coins', function (Request $request) {
    $output = shell_exec('cd .. && node capture_coins_prices.js');
    Storage::disk('public')->put('coins.html', $output);

    return [
        'foo' => 'bar'
    ];
});

// JsonApiRoute::server('v1')
//     ->prefix('v1')
//     ->resources(function (ResourceRegistrar $server) {
//         $server->resource('posts', PostController::class);
//     });