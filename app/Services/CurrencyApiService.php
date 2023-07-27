<?php

namespace App\Services;

use App\Models\BankAccount;
use GuzzleHttp\Client;

class CurrencyApiService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getData() {
        $url = 'https://www.latvijasbanka.lv/vk/ecb.xml';
        $response = $this->client->request('GET', $url);

        return simplexml_load_string($response->getBody()->getContents())->Currencies->Currency;

    }

    public function getAccountCurrency(BankAccount $account) {
        return $account->currency;
    }

    public function fetchConversionRate($fromCurrency, $toCurrency) {
        $xmlData = $this->getData();
        $rate = 0;
        foreach ($xmlData as $currency) {
            if ($currency->ID == $fromCurrency) {
                $rate = $currency->Rate;
            }

            if ($currency->ID == $toCurrency) {
                $rate = $currency->Rate;

            }
        }
        return $rate;
    }
}
