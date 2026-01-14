<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = [
        'nom',
    ];

    /**
     * Relation avec Enseignants
     * Un département peut avoir plusieurs enseignants
     */
    public function enseignants()
    {
        return $this->hasMany(Enseignant::class);
    }

    
     // Relation avec les filières
     public function filieres()
     {
         return $this->hasMany(Filiere::class);
     }
}
