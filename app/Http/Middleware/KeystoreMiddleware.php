<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class KeystoreMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Process before request reaches the controller
        if ($request->has('data')) {
            $data = $request->input('data');
            $encryptedData = $this->encryptData($data);
            $request->merge(['encryptedData' => $encryptedData]);
        }

        $response = $next($request);

        // Process before response is sent to client
        if ($response->getContent()) {
            $content = json_decode($response->getContent(), true);
            if (isset($content['encryptedData'])) {
                $decryptedData = $this->decryptData($content['encryptedData']);
                $content['decryptedData'] = $decryptedData;
                $response->setContent(json_encode($content));
            }
        }

        return $response;
    }

    private function encryptData($data)
    {
        $method = 'aes-256-cbc';
        $key = config('app.key'); // Make sure app.key is set in .env
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encryptedData = openssl_encrypt($data, $method, $key, 0, $iv);
        return base64_encode($encryptedData . '::' . $iv);
    }

    private function decryptData($encryptedData)
    {
        $method = 'aes-256-cbc';
        $key = config('app.key'); // Make sure app.key is set in .env
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
        return openssl_decrypt($encryptedData, $method, $key, 0, $iv);
    }
}

