<?php

namespace App\Services;

class EncryptionService
{
    private $method = 'aes-256-cbc';
    private $key;
    private $iv;

    public function __construct()
    {
        $this->key = config('app.key'); // Make sure app.key is set in .env
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    public function encryptData($data)
    {
        $encryptedData = openssl_encrypt($data, $this->method, $this->key, 0, $this->iv);
        return base64_encode($encryptedData . '::' . $this->iv);
    }

    public function decryptData($encryptedData)
    {
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
        return openssl_decrypt($encryptedData, $this->method, $this->key, 0, $iv);
    }
}

