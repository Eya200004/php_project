<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Important pour générer le code

class SeanceController extends Controller
{
    public function creeSeance(Request $request)
    {
        // 1. Validation des données reçues
        $validated = $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'module_id' => 'required|exists:modules,id'
        ]);

        // 2. Ajout des données automatiques
        // Génère une chaîne aléatoire de 10 caractères pour le QR
        $validated['code_qr'] = Str::random(10); 

        // 3. Création en base de données
        $seance = Seance::create($validated);

        // 4. Retourne la réponse (avec le code QR visible)
        return response()->json([
            'message' => 'Séance créée avec succès',
            'data' => $seance
        ], 201);
    }

    public function getAllSeances()
    {
        $seances = Seance::all();
        return response()->json(['data' => $seances], 200);
    }

    public function getSeanceById($id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Séance non trouvée'], 404);
        }
        return response()->json(['data' => $seance], 200);
    }

    public function updateSeance(Request $request, $id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Séance non trouvée'], 404);
        }

        // Validation
        $validated = $request->validate([
            'date' => 'sometimes|required|date',
            'heure_debut' => 'sometimes|required',
            'heure_fin' => 'sometimes|required',
            'module_id' => 'sometimes|required|exists:modules,id',
        ]);

        // Mise à jour
        $seance->update($validated);

        return response()->json(['message' => 'Séance mise à jour', 'data' => $seance], 200);
    }

    public function deleteSeance($id)
    {
        $seance = Seance::find($id);
        if (!$seance) {
            return response()->json(['message' => 'Séance non trouvée'], 404);
        }
        $seance->delete();
        return response()->json(['message' => 'Séance supprimée'], 200);
    }

    function getSeancesByModule($module_id)
    {
        $seances = Seance::where('module_id', $module_id)->get();
        return response()->json(['data' => $seances], 200);
    }

}