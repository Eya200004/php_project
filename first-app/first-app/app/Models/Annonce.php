<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    //
    protected $fillable = [
        'titre',
        'contenu',
        'datepublication',
        'enseignant_id',
    ];

    // Une annonce appartient à un enseignant
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
