<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'titre',
        'url',
        'dateupload',
        'enseignant_id',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
