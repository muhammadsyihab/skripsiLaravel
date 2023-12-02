<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    // /**
    //  * Where to redirect users after resetting their password.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function edit()
    {
       return view('auth.passwords.reset');
    }

    public function update(Request $request)
    {
        if (!(Hash::check($request->password, auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
            if(!(strcmp($request->password, $request->password_confirmation)) == 0){
                        //New password and confirm password are not same
                        return redirect()->back()->with("error","New Password should be same as your confirmed password. Please retype new password.");
            }
            //Change Password
            $user = auth()->user();
            $user->password = bcrypt($request->password_confirmation);
            $user->save();
             
            return redirect()->back()->with("success","Password changed successfully !");
    }
}
