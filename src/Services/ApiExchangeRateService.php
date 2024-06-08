<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Contracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Enums\SupportedCurrencies;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Throw_;

/**
 * The ApiExchangeRateService is responsible for fetching exchange rates from an API.
 *
 * The class has a constructor that takes in the URL of the exchange rates API and an API key for authentication.
 * It also has a property $baseCurrency which specifies the base currency to use for the exchange rates.
 *
 * fetchRates()
 * This method is responsible for fetching the exchange rates from the API.
 * It sends a GET request to the specified API URL with the base currency as a query parameter.
 * The response is then parsed and the exchange rates are returned.
 *
 * The exchange rates are cached in a static property to avoid making multiple API requests.
 * If the exchange rates have already been fetched, the cached values are returned instead of making a new API request.
 *
 * The class uses the GuzzleHttp\Client to make the HTTP request to the API.
 */
class ApiExchangeRateService extends ExchangeRateServiceAbstract
{
    private Client $client;

    /**
     * ApiExchangeRateService constructor.
     *
     * @param string $apiUrl URL for exchange rates API.
     * @param string $apiKey API key for authentication.
     */
    public function __construct(
        private readonly string $apiUrl,
        #[\SensitiveParameter]
        private readonly string $apiKey,
        protected SupportedCurrencies $baseCurrency = SupportedCurrencies::EUR
    ) {
        $this->client = new Client();
    }


    /**
     * Fetches exchange rates from the API.
     *
     * @return array
     * @throws GuzzleException
     * @throws \Exception
     */
    public function fetchRates(): array
    {
        if (!$this->apiKey) {
            throw new \Exception('Api key is nod defined');
        }

        if (!$this->rates) {
            $params = [
                'query' => [
                    'base' => $this->baseCurrency->value,
                    'symbols' => implode(',', array_column(SupportedCurrencies::cases(), 'name')),
                ],
                'headers' => [
                    'apikey' => $this->apiKey,
                ],
            ];

            $response = $this->client->get($this->apiUrl, $params);
            $data = json_decode($response->getBody()->getContents(), true);
            $this->rates = $data['rates'];
        }

        return $this->rates;
    }
}
