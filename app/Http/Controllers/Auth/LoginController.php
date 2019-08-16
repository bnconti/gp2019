<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modelos\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use \Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

//    protected $redirectTo = '/inicio2';

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $guser = Socialite::driver('google')->stateless()->user();
        Usuario::checkUser($guser);

        $loggedUser = Usuario::where('gmail', '=', $guser->email)
            ->first();

        Session::put('user', $loggedUser);
        Session::put('persona', $loggedUser->persona);
        Session::put('first_name', $guser->user['given_name']);
        Session::save();

        return redirect('/inicio2');
    }

    public function loginWithPassword(Request $req) {
        $loggedUser = Usuario::where('mail_itt', '=', $req->email)
            ->first();
           
        if (!($loggedUser)) {
            return redirect()->back()->with('error', 'Hay un error en el email o contraseña ingresadas.');
        }
        elseif (Hash::check($req->password, $loggedUser->password)) {
            Session::put('user', $loggedUser);
            Session::put('persona', $loggedUser->persona);
            Session::put('first_name', $loggedUser->persona->nombre);
            Session::save();
            return redirect('/inicio2');
        }

        return redirect()->back()->with('error', 'Hay un error en el email o contraseña ingresadas.');
    }
}