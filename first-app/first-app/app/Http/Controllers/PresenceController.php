<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Http\Request;

class PresenceController extends Controller
{

    public function marquerPresence(Request $request)
    {
        // 1. On valide les données reçues de l'application mobile/web
        $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'etudiant_id' => 'required|exists:etudiants,id', // Assure-toi que la table 'etudiants' existe
            'code_qr_scanne' => 'required|string' // Le code que l'étudiant a scanné avec son téléphone
        ]);

        // 2. On récupère la séance dans la base de données
        $seance = Seance::findOrFail($request->seance_id);

        // 3. VÉRIFICATION DE SÉCURITÉ : Est-ce le bon QR Code ?
        if ($seance->code_qr !== $request->code_qr_scanne) {
            return response()->json(['message' => 'Code QR invalide !'], 403);
        }

        // 4. Si le code est bon, on enregistre (ou met à jour) la présence
        // updateOrCreate permet d'éviter les doublons (si l'étudiant scanne 2 fois)
        $presence = Presence::updateOrCreate(
            [
                'seance_id' => $seance->id,
                'etudiant_id' => $request->etudiant_id
            ],
            [
                'statut' => 'present',
                // 'heure_arrivee' semble accepter l'heure seule (TIME), on laisse comme ça :
                'heure_arrivee' => now()->format('H:i:s'), 
                
                // CORRECTION ICI : On envoie l'objet date complet pour satisfaire le type DATETIME de MySQL
                'horaire' => now() 
            ]
        );

        return response()->json([
            'message' => 'Présence validée avec succès !',
            'data' => $presence
        ], 200);
    }

    function getPresencesBySeance($seance_id)
    {
        $presences = Presence::where('seance_id', $seance_id)->get();
        return response()->json(['data' => $presences], 200);
    }

    function getPresencesByEtudiant($etudiant_id)
    {
        $presences = Presence::where('etudiant_id', $etudiant_id)->get();
        return response()->json(['data' => $presences], 200);
    }

    function deletePresence($id)
    {
        $presence = Presence::find($id);
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }
        $presence->delete();
        return response()->json(['message' => 'Présence supprimée avec succès'], 200);
    }

    function getAllPresences()
    {
        $presences = Presence::all();
        return response()->json(['data' => $presences], 200);
    }
    function getPresenceById($id)
    {
        $presence = Presence::find($id);
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }
        return response()->json(['data' => $presence], 200);
    }
    function updatePresence($id){
        $presence = Presence::find($id);
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }
        // Ici, tu peux ajouter la logique pour mettre à jour la présence si nécessaire
        return response()->json(['message' => 'Présence mise à jour avec succès', 'data' => $presence], 200);
    }
 
}
