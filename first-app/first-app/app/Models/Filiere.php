<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = [
        'nom',
        'semester',
        'annee_universitaire',
        'departement_id',
    ];

    // Une filière a plusieurs étudiants
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }



    // Une filière a plusieurs modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    // Une filière appartient à un département
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    //
}
