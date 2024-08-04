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
        'price',
        'one_hr_percent',
        'day_percent',
        'week_percent',
        'market_cap',
        'volume',
        'circulating_supply'
    ];


}
