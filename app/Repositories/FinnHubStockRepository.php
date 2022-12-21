<?php
namespace WSB\Repositories;

use GuzzleHttp\Client;
use WSB\Models\Stock;

class FinnHubStockRepository implements StockRepository
{
    private string $apiKey;
    const BASE_URL = 'https://finnhub.io/api/v1/';

    public function __construct()
    {
        $this->apiKey = $_ENV["FINNHUB_TOKEN"];
    }

    public function getQuote(string $symbol): ?array
    {
        $client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 4.0,
        ]);

        $paramaters = [
            "symbol" => $symbol,
            "token" => $this->apiKey,
        ];
        $response = $client->request("GET","quote", [
            "query" => $paramaters
        ]);
        $body = $response->getBody();

        return json_decode($body, true);
    }

    public function getCompanyName(string $symbol): array
    {
        $client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 4.0,
        ]);

        $paramaters = [
            "q" => $symbol,
            "token" => $this->apiKey,
        ];
        $response = $client->request("GET","search", [
            "query" => $paramaters
        ]);
        $body = $response->getBody();
        return json_decode($body, true);
    }

    public function getStock(string $symbol): Stock
    {
        return new Stock(
            $symbol,
            $this->getQuote($symbol)["c"],
            $this->getQuote($symbol)["pc"],
            $this->getCompanyName($symbol)["result"][0]["description"]
        );
    }
}