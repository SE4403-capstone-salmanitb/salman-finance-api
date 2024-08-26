<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileLoginRequest;
use App\Http\Requests\Auth\MobileRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class MobileAuthController extends Controller
{
    public function login(MobileLoginRequest $request) {
        $request->authenticate();

        abort_if($request->user()->is_mobile_user == false, 403, 
        'Maaf, login melalui aplikasi mobile saat ini tidak diizinkan. Untuk melanjutkan, silakan login melalui website kami. Jika Anda ingin mengakses aplikasi mobile, Anda dapat membuat akun baru dengan menggunakan alamat email yang berbeda. Terima kasih atas pengertiannya.');

        $request->user()->tokens()->delete();

        return response()->json([
            'user' => $request->user(),
            'access_token' => $request->user()->createToken('bearer', ['mobile'], now()->addWeek())->plainTextToken,
        ]);
    }

    public function register(MobileRegisterRequest $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => "https://i.ibb.co.com/2qXwjX3/default-blue1.png",
            'is_mobile_user' => true,
        ]);

        event(new Registered($user));

        return response()->json([
            'user' => $user,
        ], 201);
    }
}
