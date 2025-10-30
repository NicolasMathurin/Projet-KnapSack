<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnigmeReponses extends Model
{
    protected $primaryKey = 'idReponse';
    protected $table = 'EnigmeReponses';
    public $timestamps = false;
    protected $fillable = [
        'idEnigme',
        'laReponse',
        'estBonne'
    ];
}
