<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $primaryKey = 'idEvaluation';
    protected $table = 'Evaluation';
    public $timestamps = false;
    protected $fillable = [
        'alias',
        'idItem',
        'nbEtoiles',
        'commentaire'
    ];
}
