<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ressources extends Model
{
    protected $primaryKey = 'idRessource';
    protected $table = 'Ressource';

    public $timestamps = false;
    protected $fillable = [
        'description',
    ];
}
