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

class CartController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message-error', 'Vous devez vous connecter pour accéder à votre panier !');
        }
        if(session('joueur.isAdmin') == 1){
            return redirect()->route('admin.index')->with('message-error', 'Vous ne pouvez pas accéder cette page en admin !');
        }
        $idJoueur = (int)session('joueur.idJoueur');

        $cart = Cart::where('idJoueur', $idJoueur)->get();
        $tableauItems = [];
        $prixTotal = 0;
        $poidsTotal = 0;
        foreach ($cart as $item) {
            $quantite = $item->quantite;
            $item = Item::where('idItem', $item->idItem)->get()->first();
            $evalutation = Evaluation::where('idItem', $item->idItem)->get();

            $prixTotal += $item->prix * $quantite;
            $poidsTotal += $item->poids * $quantite;

            $nbEvaluation = count($evalutation);
            $etoiles = 0;
            foreach ($evalutation as $eval) {
                $etoiles += $eval->nbEtoiles;
            }

            if ($nbEvaluation == 0) {
                $moyenneEtoiles = $etoiles;
            } else {
                $moyenneEtoiles = (int)($etoiles / $nbEvaluation);
            }

            $tableauItems[$item->idItem] = [
                'idItem' => $item->idItem,
                'name' => $item->name,
                'quantite' => $quantite,
                'type' => $item->type,
                'prix' => $item->prix,
                'poids' => $item->poids,
                'utilite' => $item->utilite,
                'photo' => $item->photo,
                'etoiles' => $moyenneEtoiles
            ];

        }
        return view('cart/index', compact('tableauItems', 'prixTotal', 'poidsTotal'));
    }

    public function addCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('show.login')->with('message-error', 'Vous devez vous connecter pour ajouter un item votre panier !');
        }

        $validated = $request->validate([
            'idItem' => 'required'
        ]);

        $idJoueur = (int)session('joueur.idJoueur');

        $item = Item::where('idItem', $validated['idItem'])->get()->first();

        if ($item->quantite === 0) {
            return redirect()->back()->with('message-error', "L'item n'est plus disponible.");
        }
        try {
            DB::statement('CALL AjouterItemPanier(?, ?, ?)', [
                $idJoueur,
                $item->idItem,
                1
            ]);
            return redirect()->route('item.index')->with('message-sucess', 'Item ajouté au panier avec succès.');
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                return redirect()->back()->with('message-error', 'Quantité insuffisante.');
            } else {
                return redirect()->back()->with('message-error', 'Une erreur est survenue lors de l\'ajout de l\'item au panier.');
            }
        }
    }

    public function modifyItemQuantity(Request $request)
    {
        $idItem = $request->input('id');
        $action = $request->input('action');
        $idJoueur = (int)session('joueur.idJoueur');

        $cart = Cart::where('idJoueur', $idJoueur)->where('idItem', $idItem)->first();
        switch ($action) {
            case 'increase':
                Cart::where('idJoueur', $idJoueur)
                    ->where('idItem', $idItem)
                    ->limit(1)
                    ->update(['quantite' => DB::raw('quantite + 1')]);
                return redirect()->back()->with('message-sucess', 'La quantité a été augmenté.');
            case 'decrease':
                if ($cart->quantite > 1) {
                    Cart::where('idJoueur', $idJoueur)
                        ->where('idItem', $idItem)
                        ->limit(1)
                        ->update(['quantite' => DB::raw('quantite - 1')]);
                    return redirect()->back()->with('message-sucess', 'La quantité a été réduite.');
                } else {
                    return redirect()->back()->with('message-error', 'La quantité ne peut pas être moins que 1.');
                }
            case 'delete':
                Cart::where('idJoueur', $idJoueur)
                    ->where('idItem', $idItem)
                    ->delete();
                return redirect()->back()->with('message-sucess', "L'item à été supprimé du panier.");
        }
    }

    public function emptyCart(Request $request)
    {
        $idJoueur = (int)session('joueur.idJoueur');
        try {
            DB::statement('CALL ViderPanier(?)', [
                $idJoueur,
            ]);

            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            return redirect()->back()->with('message-sucess', 'Panier vidé');
        } catch (QueryException $e) {
            return redirect()->back()->with('message-error', 'Une erreur est survenue ');
        }
    }

    public function payCart(Request $request)
    {
        $poidsTotal = (int)$request->input('poidsTotal');
        $prixTotal = (int)$request->input('prixTotal');
        $idJoueur = (int)session('joueur.idJoueur');

        if ($prixTotal == 0) {
            return redirect()->back()->with('message-error', "Le panier est déjà vide");
        }
        if ($prixTotal > session('joueur.caps')) {
            return redirect()->back()->with('message-error', "Pas assez de caps");
        }
        if ($poidsTotal > session('joueur.poidsMax')) {
            return redirect()->back()->with('message-error', "Pas assez de poids");
        }
        try {
            DB::statement('CALL PayerPanier(?)', [
                $idJoueur,
            ]);

            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            return redirect()->back()->with('message-sucess', 'Achat effectué');
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                return redirect()->back()->with('message-error', 'Erreur');
            } else {
                return redirect()->back()->with('message-error', 'Une erreur est survenue ');
            }
        }
    }
}
