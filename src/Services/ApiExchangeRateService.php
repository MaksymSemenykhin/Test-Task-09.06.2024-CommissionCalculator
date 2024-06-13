<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Enums\SupportedCurrencies;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * ApiExchangeRateService is responsible for fetching exchange rates from an external API.
 * This service extends `ExchangeRateServiceAbstract` and uses `GuzzleHttp\Client` to make HTTP requests.
 * It caches the fetched exchange rates to minimize API requests.
 *
 * Properties:
 * - `string $apiUrl` — The URL of the exchange rates API.
 * - `string $apiKey` — The API key for authentication.
 * - `SupportedCurrencies $baseCurrency` — The base currency for the exchange rates (default: EUR).
 *
 * Methods:
 * - `__construct(string $apiUrl, string $apiKey, SupportedCurrencies $baseCurrency = SupportedCurrencies::EUR)`
 *   Initializes the service with API URL, API key, and base currency.
 *
 * - `fetchRates(): array`
 *   Fetches exchange rates from the API and caches them. If the rates are already cached, returns the cached values.
 *
 * Example:
 * ```
 * $apiService = new ApiExchangeRateService('https://api.exchangeratesapi.io/latest', 'your_api_key');
 * $rates = $apiService->fetchRates();
 * ```
 *
 * @package CommissionCalculator\Services
 */
class ApiExchangeRateService extends ExchangeRateServiceAbstract
{
    private Client $client;

    /**
     * ApiExchangeRateService constructor.
     *
     * @param string $apiUrl URL for exchange rates API.
     * @param string $apiKey API key for authentication.
     * @param SupportedCurrencies $baseCurrency Base currency for exchange rates (default: EUR).
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
     * @return array The fetched exchange rates.
     * @throws GuzzleException If there is an error making the HTTP request.
     * @throws \Exception If the API key is not defined or if there is an error fetching the rates.
     */
    public function fetchRates(): array
    {
        if (!$this->apiKey) {
            throw new \Exception('API key is not defined');
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
