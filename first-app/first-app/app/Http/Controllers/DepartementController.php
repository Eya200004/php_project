<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{

    public function createDepartement(Request $request)
    {
        $request->validate(
            [
                'nom' => 'required|string|unique:departements,nom',
            ],
            [
                'nom.required' => 'Le nom du département est obligatoire.',
                'nom.string' => 'Le nom doit être une chaîne de caractères.',
                'nom.unique' => 'Ce département existe déjà.',
            ]
        );
          
        $departement = Departement::create([
            'nom' => $request->nom
        ]);

        return response()->json([
            'message' => 'Département créé avec succès',
            'data' => $departement
        ], 201);
    }

    public function getDepartements()
    {
        $departements = Departement::all();
        return response()->json($departements);
    }

    public function getDepartementById($id)
    {
        $departement = Departement::find($id);
        if (!$departement) {
            return response()->json([
                'message' => 'Département non trouvé'
            ], 404);
        }

        return response()->json($departement);
    }

    public function updateDepartement(Request $request, $id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'message' => 'Département non trouvé'
            ], 404);
        }

        $request->validate([
            'nom' => 'required|string|unique:departements,nom,' . $departement->id,
        ]);

        $departement->nom = $request->nom;
        $departement->save();

        return response()->json([
            'message' => 'Département mis à jour avec succès',
            'data' => $departement
        ]);
    }

    

    function deleteDepartement($id)
    {
        $departement = Departement::with(['enseignants', 'filieres'])->find($id);

        if (!$departement) {
            return response()->json([
                'message' => 'Département non trouvé.'
            ], 404);
        }

        // Vérifier s'il contient des enseignants ou des filières
        if ($departement->enseignants->count() > 0 || $departement->filieres->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer ce département car il contient déjà des enseignants ou des filières.'
            ], 400);
        }

        // Supprimer le département
        $departement->delete();

        return response()->json([
            'message' => 'Département supprimé avec succès.'
        ]);
    }
}
