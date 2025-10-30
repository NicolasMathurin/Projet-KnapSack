<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
Use App\Models\Player;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function showLogin(){

        if(Auth::check()){
            return redirect()->route('item.index');
        }

        return view('Authentication.login');
    }

    public function login(Request $request){


        $validated = $request->validate([
            'userName'=>'required|max:50',
            'password'=>'required|max:50'
        ]);

        $remember = $request->has('remember');

        //dd(Player::where('userName',$validated['userName'])->first());
        $joueur = Player::where('userName',$validated['userName'])->first();


        if($joueur && Hash::check($validated['password'], $joueur->password)){
            Auth::login($joueur, $remember);
            $request->session()->regenerate();
            session()->put('joueur', $joueur);

            if($joueur->isAdmin == 1){
                return redirect()->route('admin.index');
            }
            return redirect()->route('item.index');
        }

        throw ValidationException::withMessages([
            'userName'=>'Les informations de nom d\' utilisateur ou de mot de passe sont incorrectes'
        ]);
    }
}
