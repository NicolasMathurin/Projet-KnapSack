<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'idJoueur';
    protected $table = 'Panier';

    public $timestamps = false;
    protected $fillable = [
        'idItem',
        'quantite'
    ];
}
