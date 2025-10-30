<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistiquesEnigme extends Model
{
    protected $primaryKey = 'idJoueur';
    protected $table = 'StatistiquesEnigme';

    public $timestamps = false;
    protected $fillable = [
        'idEnigme',
        'enigmesReussies',
        'enigmesEchouees',
        'serieDifficile',
    ];
}
