<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AugmentationCaps extends Model
{
    protected $primaryKey = 'idJoueur';
    protected $table = 'AugmentationCaps';

    public $timestamps = false;
    protected $fillable = [
        'compteurAugmentation',
        'montant'
    ];
}
