<?php

namespace App\Http\Controllers;

use App\Models\Arme;
use App\Models\Cart;
use App\Models\Evaluation;
use App\Models\Item;
use App\Models\Munition;
use App\Models\Nourriture;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function addComment(Request $request){
        $validate = $request->validate([
            'commentaire' => 'required',
            'nbEtoiles' => 'required',
            'idItem' => 'required',
        ]);
        if($validate['nbEtoiles'] < 1){
            return redirect()->back()->with('message-error', 'Vous devez mettre au moins une étoile !');
        }
        $alias = session()->get('joueur.alias');


         try {
             DB::statement('CALL AjouterCommentaire(?, ?, ?, ?)', [
                 $alias,
                 $validate['idItem'],
                 $validate['nbEtoiles'],
                 $validate['commentaire']
             ]);
             return redirect()->back()->with('message-sucess', 'Item ajouté au panier avec succès.');
         } catch (QueryException $e) {
             if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                 return redirect()->back()->with('message-error', 'Quantité insuffisante.');
             } else {
                 return redirect()->back()->with('message-error', 'Une erreur est survenue lors de l\'ajout de l\'item au panier.');
             }
         }

        return redirect()->back()->with('message-sucess', 'Commentaire ajouté !');
    }

    public function removeComment(Request $request){
        $idJoueur = session()->get('joueur.idJoueur');

        try {
            DB::statement('CALL SupprimerCommentaire(?)', [
                $request->input('idEvaluation')
            ]);
            return redirect()->back()->with('message-sucess', 'Commentaire supprimer !');
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                return redirect()->back()->with('message-error', 'Quantité insuffisante.');
            } else {
                return redirect()->back()->with('message-error', 'Une erreur est survenue lors de l\'ajout de l\'item au panier.');
            }
        }
        return redirect()->back()->with('message-sucess', 'Commentaire supprimer');
    }

}
