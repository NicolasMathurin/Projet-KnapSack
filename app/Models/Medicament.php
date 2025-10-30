<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $primaryKey = 'idMedicament';
    protected $table = 'Medicament';

    public $timestamps = false;
    protected $fillable = [
        'effetAttendu',
        'dureeEffet',
        'effetIndesirable'
    ];
}
