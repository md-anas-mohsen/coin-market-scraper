<?php

namespace App\Spiders;

use App\Processors\CoinMarketCapSaveToDBProcessor;
use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;

class CoinMarketCapSpider extends BasicSpider
{
    public array $startUrls = [
        'http://localhost:8000/coins-html/'
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [
            UserAgentMiddleware::class, 
            ['userAgent' => 'Mozilla/5.0 (compatible; RoachPHP/0.1.0)'],
        ]
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        CoinMarketCapSaveToDBProcessor::class
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $title = $response->filter('h1')->text();

        $columns = $response
                    ->filter('th.stickyTop div div p')
                    ->each(fn(Crawler $node) => $node->text());

        $columns_count = $response->filter('th.stickyTop')->count();

        $rows = $response->filter('tbody tr')->each(function (Crawler $row) use($columns, $columns_count) {
            $col_data = [];
            
            for($i = 0; $i < $columns_count; $i++) {
                $col_data[] = $row->filter('td')->eq($i);
            }
            
            $img_src = $col_data[2]->filter('div a div img')->attr('src');
            $name = $col_data[2]->filter('div div p')->first()->text();
            $code = $col_data[2]->filter('div div p')->last()->text();

            $matches = [];
            $price = $col_data[3]->filter('div span')->text();
            $regex = '/^([^\d]+)([\d,\.]+)/';
            preg_match($regex, $price, $matches);
            $currency = $matches[1];
            $price = floatval(str_replace(',', '', $matches[2]));
            
            $one_hr_percent = floatval(str_replace('%', '', $col_data[4]->filter('span')->text()));
            $one_day_percent = floatval(str_replace('%', '', $col_data[5]->filter('span')->text()));
            $one_week_percent = floatval(str_replace('%', '', $col_data[6]->filter('span')->text()));
            
            $market_cap = $col_data[7]->filter('p')->children('span')->eq(1)->text();
            $matches = [];
            preg_match($regex, $market_cap, $matches);
            $currency = $matches[1];
            $market_cap = floatval(str_replace(',', '', $matches[2]));

            $volume_coins = $col_data[8]->filter('div div p')->text();
            $volume_coins = floatval(str_replace(',', '', explode(' ', $volume_coins)[0]));
            $volume_amount = $col_data[8]->filter('div a p')->text();
            $matches = [];
            preg_match($regex, $volume_amount, $matches);
            $currency = $matches[1];
            $volume_amount = floatval(str_replace(',', '', $matches[2]));

            $circulating_supply = $col_data[9]->filter('div div p')->text();
            $circulating_supply = floatval(str_replace(',', '', explode(' ', $circulating_supply)[0]));

            $data = [];
            $data[$columns[1]] = [
                'img_src' => $img_src,
                'name' => $name,
                'code' => $code,
            ];

            $data[$columns[2]] = [
                'price' => $price,
                'currency' => $currency
            ];
            $data[$columns[3]] = $one_hr_percent;
            $data[$columns[4]] = $one_day_percent;
            $data[$columns[5]] = $one_week_percent;
            $data[$columns[6]] = $market_cap;
            $data[$columns[7]] = [
                'coins' => $volume_coins,
                'amount' => $volume_amount,
                'currency' => $currency,
                'unit' => $code
            ];
            $data[$columns[8]] = [
                'coins' => $circulating_supply,
                'unit' => $code
            ];
        
            return $data;
        });

        yield $this->item([
            'title' => $title,
            'columns' => $columns,
            'rows' => $rows
        ]);
    }
}
