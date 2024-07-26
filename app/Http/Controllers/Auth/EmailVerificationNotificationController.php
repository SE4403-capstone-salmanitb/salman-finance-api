<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            "user_email" => 'nullable|email|exists:users,email'
        ]);

        $user = $request->has('user_email') && $request->user()->is_admin ? 
            User::where('email', $request->user_email)->first() : 
            $request->user(); 
        
        abort_if($user->hasVerifiedEmail(), 400, "User already verified or no user_email is found");

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
