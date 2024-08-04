<?php

namespace App\Processors;

use App\Models\Coin;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class CoinMarketCapSaveToDBProcessor implements ItemProcessorInterface
{
    use Configurable;
  
    public function __construct() {}

    public function processItem(ItemInterface $item): ItemInterface
    {
      $coins_data = $item->all()["rows"];

      $coins_db_data = array_map(function($coin) {
        return [
          'name' => $coin['Name']['name'],
          'code' => $coin['Name']['code'],
          'img_src' => $coin['Name']['img_src'],
          'price' => $coin['Price']['price'],
          'one_hr_percent' => $coin['1h %'],
          'day_percent' => $coin['24h %'],
          'week_percent' => $coin['7d %'],
          'market_cap' => $coin['Market Cap'],
          'volume_coins' => $coin['Volume(24h)']['coins'],
          'volume_amount' => $coin['Volume(24h)']['amount'],
          'circulating_supply' => $coin['Circulating Supply']['coins'],
        ];
      }, $coins_data);

      $inserted = Coin::upsert(
        $coins_db_data, 
        uniqueBy: ['name', 'code'], 
        update: [
          'img_src',
          'price',
          'one_hr_percent',
          'day_percent',
          'week_percent',
          'market_cap',
          'volume_amount',
          'volume_coins',
          'circulating_supply'
        ]
      );

        return $item->set('coins_inserted', $inserted);
    }
}