<?php

namespace App\Http\Controllers;

use App\Services\EncryptionService;
use Illuminate\Http\Request;

class DataController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function encrypt(Request $request)
    {
        $data = $request->input('data');
        $encryptedData = $this->encryptionService->encryptData($data);
        return response()->json(['encryptedData' => $encryptedData]);
    }

    public function decrypt(Request $request)
    {
        $encryptedData = $request->input('encryptedData');
        $decryptedData = $this->encryptionService->decryptData($encryptedData);
        return response()->json(['decryptedData' => $decryptedData]);
    }
}
