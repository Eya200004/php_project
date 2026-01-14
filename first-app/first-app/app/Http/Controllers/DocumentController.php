<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function createDocument(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'fichier' => 'required|file',
            'enseignant_id' => 'required|exists:enseignants,id',
        ]);

        // Lire le fichier et le convertir en base64
        $file = $request->file('fichier');
        $base64 = base64_encode(file_get_contents($file->getRealPath()));

        $document = Document::create([
            'titre' => $request->titre,
            'url' => $base64,
            'dateupload' => now(),
            'enseignant_id' => $request->enseignant_id,
        ]);

        return response()->json([
            'message' => 'Document ajouté avec succès',
            'document' => $document
        ], 201);
    }

    public function getDocumentsByEnseignant($enseignant_id)
    {
        $documents = Document::where('enseignant_id', $enseignant_id)->get();

        return response()->json([
            'success' => true,
            'documents' => $documents
        ]);
    }

    function getDocument($id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'Document non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'document' => $document
        ]);
    }


    public function deleteDocument($id)
    {
        $document = Document::find($id);

        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'Document non trouvé'
            ], 404);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document supprimé avec succès'
        ]);
    }

    public function updateDocument(Request $request, $id)
    {
        $document = Document::find($id);
    
        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'Document non trouvé'
            ], 404);
        }
    
        $request->validate([
            'titre' => 'sometimes|string',
            'fichier' => 'sometimes|file',
            'enseignant_id' => 'sometimes|exists:enseignants,id',
        ]);
    
        if ($request->has('titre')) {
            $document->titre = $request->input('titre');
        }
    
        if ($request->has('enseignant_id')) {
            $document->enseignant_id = $request->input('enseignant_id');
        }
    
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $document->url = base64_encode(file_get_contents($file->getRealPath()));
            $document->dateupload = now();
        }
    
        $document->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Document mis à jour avec succès',
            'document' => $document
        ]);
    }
    
}
