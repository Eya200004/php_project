<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'seance_id',
        'etudiant_id',
        'statut',
        'date_marquage'
    ];

    protected $casts = [
        'date_marquage' => 'datetime'
    ];

    // Relations
    public function seance()
    {
        return $this->belongsTo(Seance::class, 'seance_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }
}