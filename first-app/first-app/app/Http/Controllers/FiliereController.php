<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function createFiliere(Request $request)
    {

        // Validation avec messages personnalisés
        $request->validate(
            [
                'nom' => 'required|string',
                'semester' => 'required|string',
                'annee_universitaire' => 'required|string',
                'departement_id' => 'required|exists:departements,id',
            ],
            [
                'name.required' => 'Le nom est obligatoire.',
                'semester.required' => 'Le semester est obligatoire.',
                'annee_universitaire.required' => 'annee_universitaire est obligatoire.',
                'departement_id.required' => 'Le département est obligatoire.',
                'departement_id.exists' => 'Le département sélectionné n’existe pas.',
            ]
        );

        // Vérifier si une filière identique existe déjà
        $exists = Filiere::where('nom', $request->nom)
            ->where('semester', $request->semester)
            ->where('annee_universitaire', $request->annee_universitaire)
            ->where('departement_id', $request->departement_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Cette filière existe déjà.'
            ], 400);
        }

        $filiere = Filiere::create($request->only([
            'nom',
            'semester',
            'annee_universitaire',
            'departement_id'
        ]));

        return response()->json([
            'id' => $filiere->id,
            'nom' => $filiere->nom,
            'semester' => $filiere->semester,
            'annee_universitaire' => $filiere->annee_universitaire,
            'departement_id' => $filiere->departement_id
        ], 201);
    }


    function getAllFilieres()
    {
        $filieres = Filiere::all();
        return response()->json($filieres);
    }

    function getFiliereById($id)
    {
        $filiere = Filiere::find($id);
        return response()->json($filiere);
    }

    public function updateFiliere(Request $request, $id)
    {
        $filiere = Filiere::find($id);
        if (!$filiere) {
            return response()->json(['message' => 'Filiere non trouvée'], 404);
        }

        $request->validate([
            'nom' => 'required|string',
            'semester' => 'required|string',
            'annee_universitaire' => 'required|string',
            'departement_id' => 'required|exists:departements,id',
        ]);

        // Vérifier si une autre filière identique existe
        $exists = Filiere::where('nom', $request->nom)
            ->where('semester', $request->semester)
            ->where('annee_universitaire', $request->annee_universitaire)
            ->where('departement_id', $request->departement_id)
            ->where('id', '!=', $filiere->id) // exclure la filière actuelle
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Une autre filière avec le même nom, semestre, année universitaire et département existe déjà.'
            ], 400);
        }

        // Mettre à jour la filière
        $filiere->update($request->only(['nom', 'semester', 'annee_universitaire', 'departement_id']));

        return response()->json($filiere);
    }

    // Supprimer une filière
    public function deleteFiliere($id)
    {
        $filiere = Filiere::with(['etudiants'/*, 'modules'*/])->find($id);

        if (!$filiere) {
            return response()->json(['message' => 'Filière non trouvée'], 404);
        }

        if ($filiere->etudiants->count() > 0 /*|| $filiere->modules->count() > 0*/) {
            return response()->json([
                'message' => 'Impossible de supprimer la filière, elle contient déjà des étudiants ou des modules.'
            ], 400);
        }

        $filiere->delete();

        return response()->json(['message' => 'Filière supprimée avec succès']);
    }

    function getFilieresByDepartement($departement_id)
    {
        $filieres = Filiere::where('departement_id', $departement_id)->get();
        return response()->json($filieres);
    }
}
