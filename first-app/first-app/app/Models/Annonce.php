<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'datepublication',
        'enseignant_id',
        'filiere_id',
        'niveau',
    ];

    protected $casts = [
        'datepublication' => 'date',
    ];

    // Relation avec enseignant
    public function enseignant()
    {
        return $this->belongsTo(\App\Models\Enseignant::class);
    }
}