<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function settings()
    {

        return view('profile.setting');
    }

    public function update(Request $request)
    {

        $user = User::find(Auth::user()->id);
        // dd($request);
        //$user = Auth::user();
        $checkpassword = Hash::check($request->input('old-password'), Auth::user()->password);


        if ($checkpassword == FALSE) {
            return redirect()->route('settings')->with('error_message', 'Mot de passe incorrect !');
        } else {
            if (($request->input('old-password') != NULL) and ($request->input('confirm-new-password') != NULL)) {
                if ($request->input('new-password') == $request->input('confirm-new-password')) {
                    $user->password = Hash::make($request->input('new-password'));
                } else {
                    return redirect()->route('settings')->with('error_message', 'Les mots de pass ne correspondent pas!');
                }
            }
        }

        $user->name = $request->name;
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('settings')->with('success_message', 'Profile editer avec succes!');
    }


    public function account()
    {
        return view('profile.account');
    }
}
