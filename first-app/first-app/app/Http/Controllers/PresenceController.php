<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Presence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresenceController extends Controller
{
    /**
     * Marquer la présence d'un étudiant via QR code
     */
    public function marquerPresence(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'code_qr' => 'required|string',
            'etudiant_id' => 'required|exists:etudiants,id'
        ]);

        // 2. Décoder le QR code (base64-encoded JSON)
        $qrData = null;
        $seance = null;

        try {
            // Essayer de décoder comme base64
            $decodedJson = base64_decode($validated['code_qr'], true);
            if ($decodedJson !== false) {
                $qrData = json_decode($decodedJson, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($qrData['moduleId'])) {
                    // Le QR code contient des données JSON
                    // Chercher la séance par module_id et timestamp
                    $moduleId = $qrData['moduleId'];
                    
                    // Chercher la séance correspondante
                    $seance = Seance::where('module_id', $moduleId)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if (!$seance) {
                        return response()->json([
                            'message' => 'Séance introuvable pour ce module'
                        ], 404);
                    }
                }
            }
            
            // Si ce n'est pas du JSON, chercher comme un simple code_qr
            if (!$seance) {
                $seance = Seance::where('code_qr', $validated['code_qr'])->first();
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors du décodage du QR code: ' . $e->getMessage()
            ], 400);
        }
        
        if (!$seance) {
            return response()->json([
                'message' => 'Code QR invalide ou séance introuvable'
            ], 404);
        }

        // 3. Vérifier que la séance est aujourd'hui
        $today = Carbon::today()->toDateString();
        if ($seance->date !== $today) {
            return response()->json([
                'message' => 'Cette séance n\'est pas active aujourd\'hui. Date de la séance: ' . $seance->date
            ], 400);
        }

        // 4. Vérifier l'horaire (optionnel mais recommandé)
        $now = Carbon::now()->format('H:i:s');
        $heureDebut = Carbon::parse($seance->heure_debut)->subMinutes(15)->format('H:i:s'); // 15 min avant
        $heureFin = Carbon::parse($seance->heure_fin)->addMinutes(30)->format('H:i:s'); // 30 min après
        
        if ($now < $heureDebut || $now > $heureFin) {
            return response()->json([
                'message' => 'Le scan n\'est possible que pendant la séance (' . 
                           $seance->heure_debut . ' - ' . $seance->heure_fin . ')'
            ], 400);
        }

        // 5. Vérifier si l'étudiant a déjà marqué sa présence pour cette séance
        $presenceExistante = Presence::where('seance_id', $seance->id)
            ->where('etudiant_id', $validated['etudiant_id'])
            ->first();

        if ($presenceExistante) {
            return response()->json([
                'message' => 'Vous avez déjà marqué votre présence pour cette séance',
                'data' => $presenceExistante
            ], 400);
        }

        // 6. Créer la présence
        $presence = Presence::create([
            'seance_id' => $seance->id,
            'etudiant_id' => $validated['etudiant_id'],
            'statut' => 'present',
            'date_marquage' => Carbon::now()
        ]);

        // 7. Charger les relations pour la réponse
        $presence->load(['seance', 'etudiant']);

        return response()->json([
            'message' => 'Présence marquée avec succès pour la séance du ' . $seance->date,
            'data' => $presence
        ], 201);
    }

    /**
     * Obtenir toutes les présences d'une séance
     */
    public function getPresencesBySeance($seance_id)
    {
        $presences = Presence::where('seance_id', $seance_id)
            ->with(['etudiant'])
            ->get();
            
        return response()->json([
            'data' => $presences,
            'count' => $presences->count()
        ], 200);
    }

    /**
     * Obtenir toutes les présences d'un étudiant
     */
    public function getPresencesByEtudiant($etudiant_id)
    {
        $presences = Presence::where('etudiant_id', $etudiant_id)
            ->with(['seance'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'data' => $presences,
            'count' => $presences->count()
        ], 200);
    }

    /**
     * Obtenir toutes les présences
     */
    public function getAllPresences()
    {
        $presences = Presence::with(['seance', 'etudiant'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'data' => $presences,
            'count' => $presences->count()
        ], 200);
    }

    /**
     * Obtenir une présence par ID
     */
    public function getPresenceById($id)
    {
        $presence = Presence::with(['seance', 'etudiant'])->find($id);
        
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }
        
        return response()->json(['data' => $presence], 200);
    }

    /**
     * Mettre à jour une présence
     */
    public function updatePresence(Request $request, $id)
    {
        $presence = Presence::find($id);
        
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }

        $validated = $request->validate([
            'statut' => 'sometimes|required|in:present,absent,retard',
            'date_marquage' => 'sometimes|nullable|date'
        ]);

        $presence->update($validated);

        return response()->json([
            'message' => 'Présence mise à jour avec succès',
            'data' => $presence
        ], 200);
    }

    /**
     * Supprimer une présence
     */
    public function deletePresence($id)
    {
        $presence = Presence::find($id);
        
        if (!$presence) {
            return response()->json(['message' => 'Présence non trouvée'], 404);
        }
        
        $presence->delete();
        
        return response()->json([
            'message' => 'Présence supprimée avec succès'
        ], 200);
    }
}