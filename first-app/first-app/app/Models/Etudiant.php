<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'apogee',
        'user_id',
        'filiere_id',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //  Etudiant appartient à une Filiere
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }







    
    // Etudiant a plusieurs présences
    public function presences()
    {
        return $this->hasMany(Presence::class);
    }


}
