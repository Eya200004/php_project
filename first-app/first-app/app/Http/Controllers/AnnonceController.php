<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    //

    public function createAnnonce(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'contenu' => 'required|string',
            'datepublication' => 'required|date',
            'enseignant_id' => 'required|exists:enseignants,id',
        ]);

        $annonce = Annonce::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'datepublication' => $request->datepublication,
            'enseignant_id' => $request->enseignant_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Annonce créée avec succès',
            'annonce' => $annonce
        ], 201);
    }

 
    public function getAllAnnonces()
    {
        $annonces = Annonce::with('enseignant.user')->get();

        return response()->json([
            'success' => true,
            'annonces' => $annonces
        ]);
    }

   
    public function getAnnonceById($id)
    {
        $annonce = Annonce::with('enseignant.user')->find($id);

        if (!$annonce) {
            return response()->json([
                'success' => false,
                'message' => 'Annonce non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'annonce' => $annonce
        ]);
    }

    public function getAnnoncesByEnseignant($enseignant_id)
    {
        $annonces = Annonce::where('enseignant_id', $enseignant_id)->get();

        return response()->json([
            'success' => true,
            'annonces' => $annonces
        ]);
    }

    public function updateAnnonce(Request $request, $id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json([
                'success' => false,
                'message' => 'Annonce non trouvée'
            ], 404);
        }

        $request->validate([
            'titre' => 'sometimes|required|string',
            'contenu' => 'sometimes|required|string',
            'datepublication' => 'sometimes|required|date',
            'enseignant_id' => 'sometimes|required|exists:enseignants,id',
        ]);

        if ($request->filled('titre')) {
            $annonce->titre = $request->titre;
        }

        if ($request->filled('contenu')) {
            $annonce->contenu = $request->contenu;
        }

        if ($request->filled('datepublication')) {
            $annonce->datepublication = $request->datepublication;
        }

        if ($request->filled('enseignant_id')) {
            $annonce->enseignant_id = $request->enseignant_id;
        }

        $annonce->save();

        return response()->json([
            'success' => true,
            'message' => 'Annonce mise à jour avec succès',
            'annonce' => $annonce
        ]);
    }


    public function deleteAnnonce($id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json([
                'success' => false,
                'message' => 'Annonce non trouvée'
            ], 404);
        }

        $annonce->delete();

        return response()->json([
            'success' => true,
            'message' => 'Annonce supprimée avec succès'
        ]);
    }

}
