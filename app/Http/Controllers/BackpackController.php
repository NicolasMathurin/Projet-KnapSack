<?php

namespace App\Http\Controllers;

use App\Models\Backpack;
use App\Models\Cart;
use App\Models\Evaluation;
use App\Models\Munition;
use App\Models\Medicament;
use App\Models\Item;
use App\Models\Player;
use App\Models\Nourriture;
use App\Models\Armure;
use App\Models\Arme;
use App\Models\Ressources;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackpackController extends Controller
{
    public function index()
    {
        $pourcentageDeVente = 60;
        //$items = SacADos::all();
        if (!Auth::check()) {
            return redirect()->route('login')->with('message-error', 'Vous devez vous connecter pour accéder au sac à dos !');
        }
        if(session('joueur.isAdmin') == 1){
            return redirect()->route('admin.index')->with('message-error', 'Vous ne pouvez pas accéder cette page en admin !');
        }

        $Backpack = Backpack::where('idJoueur', (int)session('joueur.idJoueur'))->get();
        $tableauItems = [];
        foreach ($Backpack as $item) {
            $quantite = $item->quantite;
            $item = Item::where('idItem', $item->idItem)->get()->first();
            $evalutation = Evaluation::where('idItem', $item->idItem)->get();
            //$evalutation = Evaluation::all();

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
                'prix' => $item->prix * $pourcentageDeVente/100,
                'poids' => $item->poids,
                'utilite' => $item->utilite,
                'photo' => $item->photo,
                'etoiles' => $moyenneEtoiles
            ];

        }
        return view('backpack.index', compact('tableauItems'));
    }

    public function details($id)
    {
        $itemModel = Item::find($id);
        if (!$itemModel) {
            return redirect()->route('item.index')->with('message-error', 'Item non trouvé');
        }
        $quantite = Backpack::where('idJoueur', (int)session('joueur.idJoueur'))->where('idItem', $id)->get()->first()->quantite;

        //évaluation - commentaire
        $evaluation = Evaluation::where('idItem',$id)->get();
        $etoiles = 0;
        $moyenneEtoiles = 0;
        if($evaluation->count() > 0){
            foreach ($evaluation as $eval){
                $etoiles += $eval->nbEtoiles;
            }
            $moyenneEtoiles = (double)($etoiles/$evaluation->count());
        }

        // Structuration propre pour la vue
        $item = [
            'idItem' => $itemModel->idItem,
            'name' => $itemModel->name,
            'quantite' => $quantite,
            'type' => $itemModel->type,
            'prix' => $itemModel->prix,
            'poids' => $itemModel->poids,
            'utilite' => $itemModel->utilite,
            'photo' => $itemModel->photo,
            'moyenneEtoiles' => $moyenneEtoiles,
        ];

        // Munition récupérée sous forme d'objet
        $munition = null;
        if ($item['type'] === 'munition') {
            $munition = Munition::where('idMunition', $item['idItem'])->first();
        }
        $nourriture=null;
        if($item['type']==='nourriture') {
            $nourriture= Nourriture::where('idNourriture', $item['idItem'])->first();
        }
        $arme=null;
        if($item['type']==='arme') {
            $arme= Arme::where('idArme', $item['idItem'])->first();
        }
        $ressource=null;
        if($item['type']==='ressource') {
            $ressource = Ressources::where('idRessource', $item['idItem'])->first();
        }
        $armure=null;
        if($item['type']==='armure') {
            $armure = Armure::where('idArmure', $item['idItem'])->first();
        }
        $medicament=null;
        if($item['type']==='medicament') {
            $medicament = Medicament::where('idMedicament', $item['idItem'])->first();
        }



        return view('backpack.details', compact('item','evaluation', 'munition','nourriture','arme','ressource','armure','medicament'));
    }

    public function throw(request $request)
    {
        $idItem = $request->input('id');
        $idJoueur = (int)session('joueur.idJoueur');
        $quantite = 1;

        try {
            DB::statement('CALL JeterItem(?, ?, ?)', [$idJoueur, $idItem, $quantite]);

            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            return redirect()->route('backpack.index')->with('message-sucess', 'Item jeter !');
        } catch (QueryException $e) {
            return redirect()->back()->with('message-error', 'Une erreur est survenue ');

        }

        return redirect()->route('backpack.index')->with('message-sucess', 'Item jeter !');
    }

    public function consume(Request $request)
    {
        $idItem = $request->input('id');
        $idJoueur = (int)session('joueur.idJoueur');
        $quantite = 1;

        try {
            DB::statement('CALL ConsommerItem(?, ?)', [$idJoueur, $idItem]);


            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            return redirect()->back()->with('message-sucess', 'Item consommé');
        } catch (QueryException $e) {
            return redirect()->back()->with('message-error', 'Une erreur est survenue ');

        }

        return redirect()->route('backpack.index')->with('message-sucess', 'Item consommé');
    }

    public function sell(Request $request){
        $idItem = $request->input('id');
        $quantite = $request->input('quantity');
        $idJoueur = (int)session('joueur.idJoueur');
        $itemBackpack = Backpack::where('idJoueur', (int)session('joueur.idJoueur'))->where('idItem',$idItem)->get();

        if($itemBackpack == null){
            return redirect()->back()->with('message-error', 'Cet item n\'existe pas');
        }

        $quantiteMax = $itemBackpack[0]->quantite;

        if($quantite > $quantiteMax){
            return  redirect()->route('backpack.index')->with('message-error', 'Votre stock personnel est insuffisant');
        }
        try {
            DB::statement('CALL VendreItem(?, ?, ?)', [$idJoueur, $idItem, $quantite]);

            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            return redirect()->back()->with('message-sucess', 'Item vendu');
        } catch (QueryException $e) {
            return redirect()->back()->with('message-error', 'Une erreur est survenue ');

        }
    }
}
