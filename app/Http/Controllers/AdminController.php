<?php

namespace App\Http\Controllers;

use App\Models\AugmentationCaps;
use App\Models\Item;
use App\Models\Evaluation;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message-error', 'Vous devez vous connecter pour accéder à cette page !');
        }
        if(session('joueur.isAdmin') != 1){
            return redirect()->route('item.index')->with('message-error', 'Vous n\'avez pas accès à cette page !');
        }
        $players = Player::where('isAdmin', 0)->get();
        return view('admin.index')->with(compact('players'));
    }
    public function comment(){
        $evaluations = Evaluation::all();
        return view('admin.comment', compact('evaluations'));
    }

    public function addCaps(Request $request){
        $idJoueur = $request->input('idJoueur');
        $playerModel = Player::find($idJoueur);

        if (!$playerModel) {
            return redirect()->route('admin.index')->with('message-error', 'Le joueur n\'existe pas');
        }

        $statAugmentation = AugmentationCaps::where('idJoueur', $idJoueur)->get()->first();
        if($statAugmentation != null){
            if ($statAugmentation->compteurAugmentation >= 3) {
                return redirect()->back()->with('message-error', 'Cet utilisateur a déjà été augmenter 3 fois !');
            }
        }

        try {
            DB::statement('CALL AugmenterCapsAdmin(?)', [
                $idJoueur
            ]);
            return redirect()->back()->with('message-sucess', 'Caps ajoutés');
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                return redirect()->back()->with('message-error', 'Erreur');
            } else {
                return redirect()->back()->with('message-error', 'Une erreur est survenue ');
            }
        }
    }
}
