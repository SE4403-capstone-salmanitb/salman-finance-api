<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index(Request $request) {
        if ( !$request->user()->tokenCan("admin") && !Auth::user()->is_admin){
            throw new AuthenticationException();
        }

        $query = User::query();

        $filters = [
            "id",
            "name",
            "email",
            "email_verified_at",
            "is_admin",
            "profile_picture",
            "created_at",
            "updated_at"
        ];

        foreach ($filters as $key) {
            if ($request->has($key)){
                $query->where($key, 'like', '%'.$request->input($key).'%');
            }
        }

        return response()->json($query->get());
    }

    public function toggleAdmin(User $user, Request $request)
    {
        if ( !$request->user()->tokenCan("admin") && !Auth::user()->is_admin){
            throw new AuthenticationException();
        }

        $user->updateOrFail([
            "is_admin" => !$user->is_admin
        ]);

        return response()->json($user);
    }
}
