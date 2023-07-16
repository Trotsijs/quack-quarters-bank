<?php

namespace App\Services;

use GuzzleHttp\Client;

class CryptoApiService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getReport()
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?start=1&convert=USD';
        $headers = [
            'X-CMC_PRO_API_KEY' => env('CRYPTO_API_KEY'),
            'Accept' => 'application/json',
        ];

        $response = $this->client->request('GET', $url, [
            'headers' => $headers,
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getCoinById($id)
    {
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $headers = [
            'X-CMC_PRO_API_KEY' => env('CRYPTO_API_KEY'),
            'Accept' => 'application/json',
        ];

        $response = $this->client->request('GET', $url, [
            'headers' => $headers,
            'query' => [
                'id' => $id,
            ],
        ]);

        return json_decode($response->getBody()->getContents())->data->{$id};
    }


    public function getInfoById($id)
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info?id=' . $id;
        $headers = [
            'X-CMC_PRO_API_KEY' => env('CRYPTO_API_KEY'),
            'Accept' => 'application/json',
        ];

        $response = $this->client->request('GET', $url, [
            'headers' => $headers,
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
