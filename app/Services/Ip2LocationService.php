<?php

namespace App\Services;

use GuzzleHttp\Client;
use AwdStudio\LaravelEncryptionKeyStore\Facades\KeyStore;

class Ip2LocationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = KeyStore::get('4A0F3E7EA2D77553E337D8D05D9C60B7');
    }

    public function getIpDetails($ip)
    {
        $response = $this->client->request('GET', 'https://api.ip2location.io', [
            'query' => [
                'key' => $this->apiKey,
                'ip' => $ip,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
