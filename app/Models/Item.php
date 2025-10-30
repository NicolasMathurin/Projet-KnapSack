<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'idItem';
    protected $table = 'Items';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'quantite',
        'type',
        'prix',
        'poids',
        'utilite',
        'photo'
    ];
}
