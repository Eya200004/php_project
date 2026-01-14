<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function createUser(Request $req){
        $user = User::create([
            "name"=>$req->input('name'),
            "prenom"=>$req->input('prenom'),
            "email"=>$req->input('email'),
            "password"=>$req->input('password'),
            "role"=>'admin'

        ]);
        return $user;
    }
    
    function login(Request $req){
        try {
            //on verifier si l'user existe
            $etd = User::where('email', $req->input('email'))->first();
            if(!$etd){
                return response()->json(['message' => 'USER not found'], 404);
            }
            //on verifier le password
            if(!Hash::check($req->input('password'), $etd->password)){
                return response()->json(['message' => 'Invalide password'], 401);
            }
            //creer un token
            $token = $etd->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $etd->id,
                    'name' => $etd->name,
                    'prenom' => $etd->prenom,
                    'email' => $etd->email,
                    'role' => $etd->role,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    function getStats(){
        $totalStudents = Etudiant::count();
        $totalTeachers = Enseignant::count();
        $totalPrograms = Filiere::count();
        // For avg attendance, need to calculate from presences
        $totalPresences = \App\Models\Presence::where('present', true)->count();
        $totalSeances = \App\Models\Seance::count();
        $avgAttendance = $totalSeances > 0 ? round(($totalPresences / $totalSeances) * 100, 1) : 0;

        return response()->json([
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalPrograms' => $totalPrograms,
            'avgAttendance' => $avgAttendance . '%'
        ]);
    }

}
