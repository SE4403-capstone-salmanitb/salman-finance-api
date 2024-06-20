<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function update(Request $request){
        $request->validate([
            "name" => ['string', 'nullable', 'max:255'],
            "profile_picture" => ['nullable', 'url', 'regex:/\.(jpeg|jpg|png|bmp|gif|svg)$/i'] # regex for image url
        ]);

        $request->user()->updateOrFail(array_filter([
            "name" => $request->name,
            "profile_picture" => $request->profile_picture
        ]));

        return response()->json($request->user()); 
    }
}
