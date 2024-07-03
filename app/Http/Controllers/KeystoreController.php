<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Keystore;

class KeystoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'key_value' => 'required|string',
        ]);

        // Enkripsi nilai kunci sebelum menyimpan
        $encryptedValue = Crypt::encrypt($request->key_value);

        // Simpan kunci di database
        $keystore = new Keystore();
        $keystore->key_name = $request->key_name;
        $keystore->key_value = $encryptedValue;
        $keystore->save();

        return response()->json(['message' => 'Key stored successfully.']);
    }

    public function retrieve($key_name)
    {
        $keystore = Keystore::where('key_name', $key_name)->first();

        if (!$keystore) {
            return response()->json(['message' => 'Key not found.'], 404);
        }

        // Dekripsi nilai kunci
        $decryptedValue = Crypt::decrypt($keystore->key_value);

        return response()->json(['key_value' => $decryptedValue]);
    }
}