<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\RequestException;

class KotaniPayService
{
    private $client;

    public function __construct()
{
    $this->client = new Client([
        'base_uri' => Config::get('kotanipay.base_uri'),
        'headers' => [
            'Authorization' => 'Bearer ' . Config::get('kotanipay.api_key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        'timeout' => Config::get('kotanipay.timeout'),
    ]);
}

    /**
     * Send fiat to mobile money
     *
     * @param array $data
     * @return array|null
     */
    public function sendToMobileMoney(array $data)
    {
        try {
            Log::info('Sending fiat to mobile money', ['data' => $data]);

            $response = $this->client->post('withdraw/mobile-money', [
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('Error sending fiat to mobile money', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                'data' => $data,
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Deposit fiat to KotaniPay wallet
     *
     * @param array $data
     * @return array|null
     */
    public function depositToFiatWallet(array $data)
    {
        try {
            Log::info('Depositing fiat to wallet', ['data' => $data]);

            $response = $this->client->post('onramp/fiat-to-crypto/mobile-money', [
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('Error depositing fiat to wallet', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                'data' => $data,
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Transfer stable tokens
     *
     * @param array $data
     * @return array|null
     */
    public function transferStableToken(array $data)
    {
        try {
            Log::info('Transferring stable tokens', ['data' => $data]);

            $response = $this->client->post('transfer', [
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('Error transferring stable tokens', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                'data' => $data,
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Fetch on-ramp conversion rates
     *
     * @return array|null
     */
    public function getOnRampRates($from, $to, $fiatAmount)
{
    try {
        Log::info('Fetching on-ramp conversion rates');

        $response = $this->client->post('rate/onramp', [
            'json' => [
                'from' => $from,
                'to' => $to,
                'fiatAmount' => $fiatAmount,
            ],
        ]);

        return json_decode($response->getBody(), true);
    } catch (RequestException $e) {
        Log::error('Error fetching on-ramp rates', [
            'error' => $e->getMessage(),
            'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
        ]);

        return ['success' => false, 'error' => $e->getMessage()];
    }
}

public function getOffRampRates($from, $to, $cryptoAmount)
{
    try {
        Log::info('Fetching off-ramp conversion rates');

        $response = $this->client->post('rate/offramp', [
            'json' => [
                'from' => $from,
                'to' => $to,
                'cryptoAmount' => $cryptoAmount,
            ],
        ]);

        return json_decode($response->getBody(), true);
    } catch (RequestException $e) {
        Log::error('Error fetching off-ramp rates', [
            'error' => $e->getMessage(),
            'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
        ]);

        return ['success' => false, 'error' => $e->getMessage()];
    }
}


public function getConversionRates()
{
    try {
        // Default values for rates (can be adjusted as needed)
        $onRampRates = $this->getOnRampRates('KES', 'USDT', 100);
        $offRampRates = $this->getOffRampRates('USDT', 'KES', 1);

        $conversionRates = [];
        if (isset($onRampRates['data'])) {
            $conversionRates = array_merge($conversionRates, $onRampRates['data']);
        }
        if (isset($offRampRates['data'])) {
            $conversionRates = array_merge($conversionRates, $offRampRates['data']);
        }

        return $conversionRates;
    } catch (\Exception $e) {
        Log::error('Error fetching conversion rates', ['error' => $e->getMessage()]);
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

    /**
     * Get wallet details
     *
     * @param string $walletId
     * @return array|null
     */
    public function getWalletDetails(string $walletId)
    {
        try {
            Log::info('Fetching wallet details', ['wallet_id' => $walletId]);

            $response = $this->client->get("wallets/{$walletId}");

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('Error fetching wallet details', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                'wallet_id' => $walletId,
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
