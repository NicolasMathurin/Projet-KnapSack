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
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{

    public function index(){

        if(session('joueur.isAdmin') == 1){
            return redirect()->route('admin.index')->with('message-error', 'Vous ne pouvez pas accéder cette page en admin !');
        }

        $items = Item::orderBy('prix','desc')
            ->orderBy('poids','desc')
            ->get();

        $tableauItems = [];
        foreach ($items as $item){
            $evalutation = Evaluation::where('idItem',$item->idItem)->get();

            $nbEvaluation = count($evalutation);
            $etoiles = 0;
            foreach ($evalutation as $eval){
                $etoiles += $eval->nbEtoiles;
            }

            if($nbEvaluation == 0){
                $moyenneEtoiles = $etoiles;
            }
            else{
                $moyenneEtoiles = (int)($etoiles/$nbEvaluation);
            }


            $tableauItems[$item->idItem] = [
                'idItem' => $item->idItem,
                'name' => $item->name,
                'quantite' => $item->quantite,
                'type' => $item->type,
                'prix' => $item->prix,
                'poids' => $item->poids,
                'utilite' => $item->utilite,
                'photo' => $item->photo,
                'etoiles' => $moyenneEtoiles,
                'evaluation'=> $evalutation
            ];

        }
        return view('Item.index',compact('tableauItems'));
    }

    public function details($id)
    {
        $itemModel = Item::find($id);

        if (!$itemModel) {
            return redirect()->route('item.index')->with('message-error', 'Item non trouvé');
        }

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
            'quantite' => $itemModel->quantite,
            'type' => $itemModel->type,
            'prix' => $itemModel->prix,
            'poids' => $itemModel->poids,
            'utilite' => $itemModel->utilite,
            'photo' => $itemModel->photo,
            'moyenneEtoiles' => $moyenneEtoiles,
            'evaluation'=> $evaluation,
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
        $evaluation = Evaluation::where('idItem',$id)->get();


        return view('Item.details', compact('item','evaluation', 'munition','nourriture','arme','ressource','armure','medicament'));
    }

}
