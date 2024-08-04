<?php

use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class CoinMarketCapSaveToDBProcessor implements ItemProcessorInterface
{
    use Configurable;
  
    public function __construct() {}

    public function processItem(ItemInterface $item): ItemInterface
    {
      \Log::info($item->all());
        dd($item->all());

        // return $item->set('id', $matchId);
    }
}