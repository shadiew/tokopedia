<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $settings;
    protected $isProduction;
    protected $apiKey;
    protected $merchantCode;
    protected $privateKey;

    public function __construct()
    {
        $this->settings = Settings::getSettings();
        $this->isProduction = $this->settings->tripay_action == 1;
        $this->apiKey = $this->settings->tripay_apikey;
        $this->merchantCode = $this->settings->tripay_merchant;
        $this->privateKey = $this->settings->tripay_privatekey;
    }

    public function getChannelUrl()
    {
        return $this->isProduction
            ? 'https://tripay.co.id/api/merchant/payment-channel'
            : 'https://tripay.co.id/api-sandbox/merchant/payment-channel';
    }

    public function getTransactionUrl()
    {
        return $this->isProduction
            ? 'https://tripay.co.id/api/transaction/create'
            : 'https://tripay.co.id/api-sandbox/transaction/create';
    }

    public function getChannels()
    {
        $url = $this->getChannelUrl();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($url);
        if ($response->successful()) {
            return $response->json('data');
        }
        Log::error('Tripay channel error', ['response' => $response->body()]);
        return [];
    }

    public function createTransaction($payload)
    {
        $url = $this->getTransactionUrl();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->asForm()->post($url, $payload);
        if ($response->successful()) {
            return $response->json();
        }
        Log::error('Tripay transaction error', ['response' => $response->body()]);
        return null;
    }

    public function generateSignature($merchantRef, $amount)
    {
        return hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey);
    }
} 