<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\DeleteMyAccountRequested;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserProfileController extends Controller
{
    public function update(Request $request){
        $request->validate([
            "name" => ['string', 'nullable', 'max:255'],
            "profile_picture" => ['nullable', 'url', 'regex:~^https?://(?:[a-z0-9\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpe?g|gif|png)$~'] # regex for image url
        ]);

        $request->user()->updateOrFail(array_filter([
            "name" => $request->name,
            "profile_picture" => $request->profile_picture
        ]));

        return response()->json($request->user()); 
    }

    public function deleteRequest(Request $request) {
        /** @var User */
        $user = $request->user();

        $request->validate([
            'password' => 'string|required|current_password'
        ]);

        Mail::to($user)->send(new DeleteMyAccountRequested(
            $user->name, 
            URL::temporarySignedRoute(
                'verification.delete', 
                now()->addMinutes(35), 
                [
                    'user' => $user->id,
                ],
            )
        ));

        return response()->json(['message' => 'We have send you an email containing link to verify your request']);
    }

    public function destroyUser(User $user, Request $request){
        if ($request->hasValidSignature()) {

            $user->deleteOrFail();

            return response()->redirectTo(config('app.frontend_url'));

        } else if ($request->bearerToken() && Auth::guard('sanctum')->user()->is_admin) {
            
            $user->deleteOrFail();

            return response()->json(['message' => "user with id {$user->id} is deleted successfully"]);

        } else {
            abort(403);
        }
    }
}
