<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        if(request()->user()->is_admin){
            $ability = ["*"];
        } else {
            if ($request->user()->is_mobile_user) {
                abort(403, 'Login tidak berhasil: Akses melalui perangkat mobile tidak didukung. Silakan gunakan aplikasi mobile kami atau akses melalui perangkat desktop.');
            } else {
                $ability = ['web'];
            }
        }

        $request->session()->regenerate();
        $request->user()->tokens()->delete();

        return response()->json([
            'user' => $request->user(),
            'access_token' => $request->user()->createToken('bearer', $ability, now()->addWeek())->plainTextToken,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $request->user()->tokens()->delete();
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }


    public function check(Request $request){
        return response($request->user());
    }
}
