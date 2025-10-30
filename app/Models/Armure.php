<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armure extends Model
{
    protected $primaryKey = 'idArmure';
    protected $table = 'Armure';

    public $timestamps = false;
    protected $fillable = [
        'matiere',
        'taille',
    ];
}
