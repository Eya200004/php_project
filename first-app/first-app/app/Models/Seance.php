<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'heure_debut', 'heure_fin', 'code_qr', 'module_id'];

    public function module() {
        return $this->belongsTo(Module::class);
    }
    
    public function presences() {
        return $this->hasMany(Presence::class);
    }
    
}
