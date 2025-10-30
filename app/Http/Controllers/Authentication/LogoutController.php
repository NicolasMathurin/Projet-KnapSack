<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();  // Déconnexion de l'utilisateur
            $request->session()->invalidate();  // Invalider la session
            $request->session()->regenerateToken();
            return redirect()->route('item.index');
        }
        return redirect()->route('item.index');
    }
}
