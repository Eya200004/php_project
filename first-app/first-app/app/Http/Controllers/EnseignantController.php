<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnseignantController extends Controller
{
    //
    function createEnseignant(Request $request)
    {

        // Validation avec messages personnalisés
        $request->validate(
            [
            'name' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'specialite' => 'required|string',
            'departement_id' => 'required|exists:departements,id',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'L’email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'specialite.required' => 'La specialite est obligatoire.',
            'departement_id.required' => 'Le départmenet est obligatoire.',
            'departement_id.exists' => 'Le département sélectionné n’existe pas.',
        ]);
    

        // Créer le user d'abord
        $user = User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'enseignant',
        ]);

        // Créer l'enseignant lié avec user_id
        $enseignant = Enseignant::create([
            'user_id' => $user->id,
            'specialite' => $request->specialite,
            'departement_id' => $request->departement_id,
        ]);

        return response()->json([
            'id' => $enseignant->id,
            'name' => $user->name,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'specialite' => $enseignant->specialite,
            'role' => $user->role,
            'password' => $user->password,
            'departement_id' => $enseignant->departement_id,
        ]);
    }

    function getAllEnseignants()
    {
        $enseignants = Enseignant::with('user')->get();

        return $enseignants->map(function ($ens) {
            return [
                'id' => $ens->id,
                'name' => $ens->user->name ?? null,
                'prenom' => $ens->user->prenom ?? null,
                'email' => $ens->user->email ?? null,
                'specialite' => $ens->specialite,
                'password' => $ens->user->password ?? null,
                'departement_id' => $ens->departement_id,
            ];
        });
    }

    function getEnseignantById($id)
    {
        $enseignant = Enseignant::with('user')->find($id);
        if (!$enseignant) {
            return response()->json(['message' => 'Enseignant not found'], 404);
        }

        return response()->json([
            'id' => $enseignant->id,
            'name' => $enseignant->user->name ?? null,
            'prenom' => $enseignant->user->prenom ?? null,
            'email' => $enseignant->user->email ?? null,
            'specialite' => $enseignant->specialite,
            'password' => $enseignant->user->password ?? null,
            'departement_id' => $enseignant->departement_id,
        ]);
    }

    public function updateEnseignant(Request $request, $id)
    {
        $enseignant = Enseignant::with('user')->find($id);

        if (!$enseignant) {
            return response()->json(['message' => 'Enseignant non trouvé'], 404);
        }

        // Update user
        $user = $enseignant->user;
        $user->name = $request->input('name', $user->name);
        $user->prenom = $request->input('prenom', $user->prenom);
        $user->email = $request->input('email', $user->email);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update enseignant
        $enseignant->specialite = $request->input('specialite', $enseignant->specialite);
        $enseignant->departement_id = $request->input('departement_id', $enseignant->departement_id);
        $enseignant->save();

        return response()->json([
            'message' => 'Enseignant mis à jour avec succès',
            'enseignant' => [
                'id' => $enseignant->id,
                'name' => $user->name,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'specialite' => $enseignant->specialite,
                'departement_id' => $enseignant->departement_id,
            ]
        ]);
    }



    public function deleteEnseignant($id)
    {
        $enseignant = Enseignant::with('user')->find($id);

        if (!$enseignant) {
            return response()->json(['error' => 'Enseignant non trouvé'], 404);
        }

        DB::transaction(function () use ($enseignant) {
            $enseignant->delete();

            if ($enseignant->user) {
                $enseignant->user->delete();
            }
        });

        return response()->json([
            'message' => 'Enseignant supprimé avec succès'
        ]);
    }

    function getEnseignantByDepartement($departement_id)
    {
        $enseignants = Enseignant::with('user')
            ->where('departement_id', $departement_id)
            ->get();

        return $enseignants->map(function ($ens) {
            return [
                'id' => $ens->id,
                'name' => $ens->user->name ?? null,
                'prenom' => $ens->user->prenom ?? null,
                'email' => $ens->user->email ?? null,
                'specialite' => $ens->specialite,
                'departement_id' => $ens->departement_id,
            ];
        });
    }
}
