<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backpack extends Model
{
    protected $primaryKey = 'idSac';
    protected $table = 'SacADos';
    public $timestamps = false;
    protected $fillable = [
        'idJoueur',
        'idItem',
        'quantite'
    ];
}
