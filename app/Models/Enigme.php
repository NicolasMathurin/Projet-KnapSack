<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enigme extends Model
{
    protected $primaryKey = 'idEnigme';
    protected $table = 'Enigme';

    public $timestamps = false;
    protected $fillable = [
        'enonce',
        'reponse',
        'difficulte'
    ];
}
