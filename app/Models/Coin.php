<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'img_src',
        'price',
        'one_hr_percent',
        'day_percent',
        'week_percent',
        'market_cap',
        'volume_amount',
        'volume_coins',
        'circulating_supply'
    ];


}
