<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Coins\CoinSchema;
use App\JsonApi\V1\UserCoinsWatchlists\UserCoinsWatchlistSchema;
use App\JsonApi\V1\Users\UserSchema;
use App\Models\UserCoinWatchList;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('sanctum');
        UserCoinWatchList::creating(static function (UserCoinWatchList $userCoinWatchList): void {
            $userCoinWatchList->user()->associate(Auth::user());
        });
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            UserSchema::class,
            CoinSchema::class,
            UserCoinsWatchlistSchema::class
        ];
    }
}
