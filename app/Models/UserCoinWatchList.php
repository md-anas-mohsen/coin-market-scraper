<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserCoinWatchList extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "coin_id"
    ];

    public function coin(): HasOne
    {
        return $this->hasOne(Coin::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
