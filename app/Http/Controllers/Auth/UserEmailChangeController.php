<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailChangeNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;
use Illuminate\Auth\AuthenticationException;


class UserEmailChangeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        $request->validate([
            "password" => ['required', 'string'],
            "new_email" => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email']
        ]);

        if(!password_verify($request->password, $user->password)){
            throw new AuthenticationException();
        }

        $location = Location::get();
        if (!$location){
            abort(500, 'Error reading request');
        }
        Mail::to($user)->send(new EmailChangeNotification(
            $user->name,
            $location->cityName.", ".$location->regionName.", "
                        .$location->countryName." (".$request->ip().")",
            $request->new_email
        ));

        $user->email = $request->new_email;
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();
        $user->tokens()->delete();

        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        

        return response()->noContent();
    }
}
