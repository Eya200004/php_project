<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'user_id',
        'specialite',
        'departement_id',
    ];

    /**
     * Relation avec User (héritage)
     * Un enseignant correspond à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec Département
     * Un enseignant appartient à un département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    /**
     * Relation avec Document
     * Un enseignant peut avoir plusieurs documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    /**
     * Relation avec Annonce
     * Un enseignant peut avoir plusieurs annonces
     */

    public function annonces()
{
    return $this->hasMany(Annonce::class);
}
}
