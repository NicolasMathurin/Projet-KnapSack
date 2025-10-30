<?php

namespace App\Http\Controllers;

use App\Models\Enigme;
use App\Models\EnigmeReponses;
use App\Models\Player;
use App\Models\StatistiquesEnigme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnigmaController
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message-error', 'Vous devez vous connecter pour accéder à Enigma !');
        }
        if (session('joueur.isAdmin') == 1) {
            return redirect()->route('admin.index')->with('message-error', 'Vous ne pouvez pas accéder cette page en admin !');
        }
        return view('enigma.index');
    }

    public function quiz(request $request)
    {
        $difficultes = array_filter([
            $request->input('difficulty1'),
            $request->input('difficulty2'),
            $request->input('difficulty3')
        ]);

        if (count($difficultes) < 1) {
            $difficultes = [
                0 => "facile",
                1 => "moyenne",
                2 => "difficile"
            ];
        }

        $enigme = Enigme::whereIn('difficulte', $difficultes)
            ->inRandomOrder()
            ->limit(1)
            ->get();

        $tableauReponses = [];

        for ($i = 0; $i < count($enigme); $i++) {
            $enigmeReponses = EnigmeReponses::where('idEnigme', $enigme[$i]->idEnigme)->get();

            foreach ($enigmeReponses as $reponse) {
                if ($reponse->estBonne == "o") {
                    $tableauReponses[] = ["reponse" => $reponse->laReponse,
                        "statut" => "estBonne"
                    ];
                }
                if ($reponse->estBonne == "n") {
                    $tableauReponses[] = ["reponse" => $reponse->laReponse,
                        "statut" => "estMauvaise"
                    ];
                }
            }
        }
        shuffle($tableauReponses);

        return view('enigma.quiz')->with(compact('enigme', 'tableauReponses'));
    }

    public function result(Request $request)
    {
        $idJoueur = (int)session('joueur.idJoueur');
        $idEnigme = $request->input('idEnigme');
        $reponse = $request->input('reponse');
        $difficulte = $request->input('difficulty');
        $argentGagne = 0;

        if ($reponse == "estBonne") {
            //procédure stockée
            $stats = StatistiquesEnigme::where('idJoueur', $idJoueur)->get();
            $streaks = $stats[0]->serieDifficile;
            try {
                if ($streaks == 2 && $difficulte == 'difficile') {
                    $argentGagne += 1000;
                }
                DB::statement('CALL EnigmeCapsGagnes(?,?)', [
                    $idEnigme,
                    $idJoueur
                ]);

            } catch (QueryException $e) {
                if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                    return redirect()->back()->with('message-error', 'Erreur');
                } else {
                    return redirect()->back()->with('message-error', 'Une erreur est survenue ');
                }
            }
            switch ($difficulte) {
                case 'facile':
                    $argentGagne += 50;
                    break;
                case 'moyenne':
                    $argentGagne += 100;
                    break;
                case 'difficile':
                    $argentGagne += 200;
                    break;
            }
            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);
            $messageResultat = "Vous avez eu la bonne réponse ! Vous avez gagné ". $argentGagne . " caps";
        } else {
            try {
                DB::statement('CALL EnigmesEchouees(?,?)', [
                    $idEnigme,
                    $idJoueur
                ]);

            } catch (QueryException $e) {
                if (strpos($e->getMessage(), 'Quantité insuffisante') !== false) {
                    return redirect()->back()->with('message-error', 'Erreur');
                } else {
                    return redirect()->back()->with('message-error', 'Une erreur est survenue ');
                }
            }
            $joueur = Player::where('userName', session('joueur.userName'))->first();
            session()->forget('joueur');
            session()->put('joueur', $joueur);

            $pvPerdu = 0;
            switch ($difficulte) {
                case 'facile':
                    $pvPerdu = 3;
                    break;
                case 'moyenne':
                    $pvPerdu = 6;
                    break;
                case 'difficile':
                    $pvPerdu = 10;
                    break;
            }
            $messageResultat = "Vous avez eu la mauvaise réponse :( Vous avez perdu ".$pvPerdu." pv";
        }
        return view('enigma.result')->with(compact('messageResultat', 'reponse', 'difficulte'));
    }

    public function test()
    {

        return view('enigma.test');
    }
}
