<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class APILoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($login)) {
            return response()->json([
                'code' => 400,
                'messages' => 'Username atau Password Salah'
            ])->setStatusCode(400);
        }

        $accesToken = auth()->user()->createToken('authToken')->accessToken;

        $user = User::where('email', $request->email)->first();
        $user['user_photo_url'] = 'http://103.179.86.78:8000/storage/Register/' . $user->photo;

        return response()->json([
            'code' => 200,
            'messages' => 'Logged',
            'data' => $user,
            'access_token' =>  $accesToken,
        ]);
    }

    public function updatePassword(Request $request)
    {

        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return response()->json([
                'code' => 400,
                'messages' => "Old Password Doesn't match!"
            ])->setStatusCode(400);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return response()->json([
            'code' => 200,
            'messages' => 'Success change password'
        ]);
    }
}
