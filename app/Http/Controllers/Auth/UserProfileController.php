<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\DeleteMyAccountRequested;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\File;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Exceptions\NotWritableException;
use Intervention\Image\ImageManager;

class UserProfileController extends Controller
{
    public function update(Request $request){
        $request->validate([
            "name" => ['string', 'nullable', 'max:255'],
            "profile_picture_url" => ['nullable', 'prohibits:profile_picture_raw', 'url', 'regex:~^https?://(?:[a-z0-9\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpe?g|gif|png)$~'], # regex for image url,
            "profile_picture_raw" => ['nullable', 'prohibits:profile_picture_url', File::image()->max('10mb')]
        ]);

        $uploadedImage = null; // if somehow error happened

        if ($request->has('profile_picture_raw')){
            /** @var UploadedFile */
            $image = $request->file('profile_picture_raw');

            $image_name = time().'_'.$image->getClientOriginalName();
            $path = public_path('profile') . "/" . $image_name;

            ImageManager::gd()->read($image->getRealPath())->cover(400,400)->save($path); // https://www.searchenginejournal.com/social-media-image-sizes/488891/
            
            $uploadedImage = config('app.url')."/profile/".$image_name;
        }

        $request->user()->updateOrFail(array_filter([
            "name" => $request->name,
            "profile_picture" => $request->profile_picture_url ?? $uploadedImage,
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
