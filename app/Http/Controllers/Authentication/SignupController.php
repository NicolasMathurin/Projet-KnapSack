<?php

namespace App\Http\Controllers\Authentication;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SignupController extends Controller
{
    public function showSignup(){

        if(Auth::check()){
            return redirect()->route('item.index');
        }
        return view('Authentication.signup');
    }
    public function signup(Request $request){

        $validated = $request->validate([
            'userName'=>'required|max:50|',
            'password'=>'required|max:50',
            'confirmPassword'=>'required|max:50|same:password'
        ],[
            'confirmPassword.same' => 'Les mots de passe ne correspondent pas. Veuillez réessayer.'
        ]);

        //On vérifie si l'utilisateur existe déjà dans la BD
        $utilisateurExistant = Player::where('userName', $validated['userName'])->first();

        if (!$utilisateurExistant) {

            Player::create([
               'userName' => $validated['userName'],
               'password' => bcrypt($validated['password']),
               'alias' => $validated['userName'],
                'caps' => 1000,
                'dexterite' => 100,
                'pointsVie' => 100,
                'poids' => 0,
                'poidsMax' => 1000

            ]);
            return redirect()->route('login')->with('message-sucess','Compte créer !');
        }
        throw ValidationException::withMessages([
            'existingUser'=>'L\'utilisateur existe déjà !'
        ]);
    }
}
