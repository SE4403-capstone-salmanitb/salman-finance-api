<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function showAlert()
    {
        return view('security.alert');
    }

    public function denyAccess(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('message', 'Akses telah ditolak. Silakan login kembali.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();
        return redirect('/login')->with('message', 'Password berhasil diubah. Silakan login kembali dengan password baru.');
    }
}
