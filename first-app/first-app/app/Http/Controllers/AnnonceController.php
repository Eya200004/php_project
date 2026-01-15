<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // ← AJOUTER CETTE LIGNE

class AnnonceController extends Controller
{
    public function createAnnonce(Request $request)
    {
        try {
            // Log pour déboguer
            Log::info('Tentative de création d\'annonce', $request->all());

            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'datepublication' => 'required|date',
                'enseignant_id' => 'required|exists:enseignants,id',
                'filiere_id' => 'nullable|string',
                'niveau' => 'nullable|string',
            ]);

            $annonce = Annonce::create($validated);

            Log::info('Annonce créée avec succès', ['id' => $annonce->id]);

            return response()->json([
                'success' => true,
                'message' => 'Annonce créée avec succès',
                'annonce' => $annonce
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'annonce', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'annonce: ' . $e->getMessage()
            ], 500);
        }
    }
 
    public function getAllAnnonces()
    {
        $annonces = Annonce::with('enseignant')->get();

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

    public function getAnnoncesForStudent($etudiant_id)
    {
        $etudiant = \App\Models\Etudiant::find($etudiant_id);

        if (!$etudiant) {
            return response()->json([
                'success' => false,
                'message' => 'Étudiant non trouvé'
            ], 404);
        }

        $annonces = Annonce::where(function($query) use ($etudiant) {
            $query->whereNull('filiere_id')
                  ->orWhere('filiere_id', $etudiant->filiere_id);
        })->where(function($query) use ($etudiant) {
            $query->whereNull('niveau')
                  ->orWhere('niveau', $etudiant->niveau);
        })->with('enseignant.user')
          ->get();

        return response()->json([
            'success' => true,
            'annonces' => $annonces
        ]);
    }
}