<?php

use App\Spiders\CoinMarketCapSpider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use LaravelJsonApi\Laravel\Routing\RouteRegistrar;
use RoachPHP\Roach;
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
    \Log::info("FETHCING PRICES");
    $output = shell_exec('cd .. && node capture_coins_prices.js');
    \Log::info("FETCHED PRICES");
    Storage::disk('public')->put('coins.html', $output);
    \Log::info("SAVED PRICES");
    // Roach::startSpider(CoinMarketCapSpider::class);

    return [
        'foo' => 'bar'
    ];
});

JsonApiRoute::server('v1')
    ->prefix('v1')
    ->resources(function (ResourceRegistrar $server) {
        $server->resource('users', JsonApiController::class);
        $server->resource('coins', JsonApiController::class);
    });