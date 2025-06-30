<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Notifications\SendEmailToUserResetPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Cookie;
use Illuminate\Support\Facades\Cookie as FacadesCookie;

use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(AuthRequest $request)
    {
        //dd($request);

        try {
            //code...

            $user = User::where('email', $request->email)->first();
            //dd($user->name);
            $credentials = $request->only(['email', 'password', 'name']);
            //dd($credentials);


            if (Auth::attempt($credentials)) {


                // dd($request->has('remember'));

                //if ($request->has('remember')) {

                //Cookies set successfully
                //  FacadesCookie::queue('adminemail', $request->email, 1440);
                //  FacadesCookie::queue('adminpswd', $request->password, 1440);
                //  FacadesCookie::queue('adminchek', "checked='checked'");;
                // } else {
                //     FacadesCookie::queue('adminemail', "");
                //     FacadesCookie::queue('adminpswd', "");
                //     FacadesCookie::queue('adminchek', "");;
                // }

                return redirect()->route('dashboard');
            } else {

                return redirect()->back()->with('error_msg', 'Paramètre de connexion non reconnu');
            }
        } catch (Exception) {
            //throw $th;
            return redirect()->back()->with('error_msg', 'Paramètre de connexion non reconnu');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }



    public function reset()
    {
        return view('auth.reset-password');
    }

    public function submitResetPassword(Request $request)
    {
        // dd($request);





        //Envoyer un mail pour que l'utilisateur puisse reset password

        //Envoyer un code par email pour vérification

        try {
            ResetCodePassword::where('email', $request->email)->delete();
            $code = rand(1000, 4000);

            $data = [
                'code' => $code,
                'email' => $request->email
            ];
            ResetCodePassword::create($data);

            // Notification::route('mail', $request->email)->notify(new SendEmailToUserResetPassword($code, $request->email));

            //Rediriger l'utilisateur vers une URL

            return redirect()->route('reset.password')->with('success_message', 'E-mail a été envoyé avec succès');
        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de l\'envoie du mail');
        }
    }


    public function ResetCodePassword($email)
    {
        return view('auth.reset-code-password', compact('email'));
    }

    public function storeResetPassword(Request $request)
    {

        // dd($request);
        try {
            $user = User::where('email', $request->email)->first();
            // dd($user);
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = Carbon::now();
                $user->update();


                //SI la maj s'est fait correctement
                $existingCode = ResetCodePassword::where('email', $user->email)->count();

                if ($existingCode >= 1) {
                    ResetCodePassword::where('email', $user->email)->delete();
                }
                //return redirect()->route('login')->with('success_message', 'Vos accès ont été correctement défini');
                $credentials = $request->only(['email', 'password', 'name']);
                if (Auth::attempt($credentials)) {

                    return redirect()->route('dashboard')->with('success_message', 'Le mot de passe a été modifié avec succès ');;
                }
            }
        } catch (Exception $e) {
            //dd($e);
        }
    }
}