<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NoBannedWords;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        if (!$request->user()->tokenCan('admin')){
            abort(403, 'Pendaftaran tidak berhasil: Anda tidak 
            memiliki wewenang untuk malukan pembuatan akun baru');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', new NoBannedWords()],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "profile_picture" => ['nullable', 'url', 'regex:~^https?://(?:[a-z0-9\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpe?g|gif|png)$~']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $request->profile_picture ?? "https://i.ibb.co.com/2qXwjX3/default-blue1.png",
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return response()->json([
            'user' => $user,
        ], 201);
    }
}
