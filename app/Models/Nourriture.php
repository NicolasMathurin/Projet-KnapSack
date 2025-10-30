<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nourriture extends Model
{
    protected $primaryKey = 'idNourriture';
    protected $table = 'Nourriture';

    public $timestamps = false;
    protected $fillable = [
        'apportCalorique',
        'composantNutritif',
        'mineralPrincipal',
        'gainVie',
    ];
}
