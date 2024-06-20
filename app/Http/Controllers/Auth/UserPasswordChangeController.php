<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordChangeNotification;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;
use Illuminate\Validation\Rules;


class UserPasswordChangeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            "old_password" => ['string', 'required'],
            "new_password" => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        #Match The Old Password
        if(!password_verify($request->old_password, Auth::user()->getAuthPassword())){
            throw new AuthenticationException();
        }

        $location = Location::get();
        $user = Auth::user();
        Mail::to($user)->send(new PasswordChangeNotification(
            $user->name,
            $location->cityName.", ".$location->regionName.", "
                        .$location->countryName." (".$request->ip().")"
        ));

        #Update the new Password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Auth::guard('web')->logout();
        $request->user()->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
