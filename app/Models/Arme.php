<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arme extends Model
{
    protected $primaryKey = 'idArme';
    protected $table = 'Arme';

    public $timestamps = false;
    protected $fillable = [
        'efficacite',
        'genre',
        'description',
    ];
}
