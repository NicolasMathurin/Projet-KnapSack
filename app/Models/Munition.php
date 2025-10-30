<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Munition extends Model
{
    protected $primaryKey = 'idMunition';
    protected $table = 'Munition';

    public $timestamps = false;
    protected $fillable = [
        'genre',
        'calibre',
    ];
}
