<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tripay.api_key');
        $this->privateKey = config('services.tripay.private_key');
        $this->merchantCode = config('services.tripay.merchant_code');

        $mode = config('services.tripay.mode');
        $this->baseUrl = ($mode === 'PRODUCTION')
            ? 'https://tripay.co.id/api'
            : 'https://tripay.co.id/api-sandbox';
    }

    public function getPaymentChannels()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/merchant/payment-channel');

        return $response->json()['data'] ?? [];
    }

    public function createTransaction($transaction, $user, $position, $packageType, $paymentChannels, $phone_number)
    {
        $signature = hash_hmac(
            'sha256',
            $this->merchantCode . $transaction->reference . $transaction->amount,
            $this->privateKey
        );


        $payload = [
            'method'         => $paymentChannels,
            'merchant_ref'   => $transaction->reference,
            'amount'         => $transaction->amount,
            'customer_name'  => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $phone_number,
            'order_items'    => [
                [
                    'sku'      => $packageType . '-' . $position->id,
                    'name'     => 'Paket ' . ucfirst($packageType) . ' - ' . $position->name,
                    'price'    => $transaction->amount,
                    'quantity' => 1,
                ]
            ],
            'callback_url'   => route('api.tripay.callback'),
            'return_url'     => route('students.packages.index'),
            'expired_time'   => (time() + (24 * 60 * 60)),
            'signature'      => $signature
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl . '/transaction/create', $payload);

        return $response->json();
    }
}
