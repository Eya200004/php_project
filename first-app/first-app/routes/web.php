<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/users/register',[UserController::class, 'createUser']);
Route::post('/api/users/login',[UserController::class, 'login']);

Route::prefix('api')->middleware('auth:sanctum')->group(function () {

Route::get('/dashboard/stats',[UserController::class, 'getStats']);

// """"""""""""""""""""""Etudiant routes #############################"
Route::post('/etudiants/add',[EtudiantController::class, 'createEtudiant']);
Route::get('/etudiants',[EtudiantController::class, 'getAllEtudiant']);
Route::get('/etudiants/{id}',[EtudiantController::class, 'getEtudiant']);
Route::put('/etudiants/{id}',[EtudiantController::class, 'updateEtudiant']);
Route::delete('/etudiants/{id}',[EtudiantController::class, 'deleteEtudiant']);
Route::get('/etudiants/filiere/{filiere_id}',[EtudiantController::class, 'getEtudiantsByFiliere']);

// """"""""""""""""""""""Enseignant routes #############################"

Route::post('/enseignants/add',[EnseignantController::class, 'createEnseignant']);
Route::get('/enseignants',[EnseignantController::class, 'getAllEnseignants']);
Route::get('/enseignants/{id}',[EnseignantController::class, 'getEnseignantById']);
Route::put('/enseignants/{id}',[EnseignantController::class, 'updateEnseignant']);
Route::delete('/enseignants/{id}',[EnseignantController::class, 'deleteEnseignant']);
Route::get('/enseignants/departement/{departement_id}',[EnseignantController::class, 'getEnseignantByDepartement']);

 // """"""""""""""""""""""Departement routes #############################"

Route::post('/departements/add',[DepartementController::class, 'createDepartement']);
Route::get('/departements',[DepartementController::class, 'getDepartements']); 
Route::get('/departements/{id}',[DepartementController::class, 'getDepartementById']);
Route::delete('/departements/{id}',[DepartementController::class, 'deleteDepartement']);
Route::put('/departements/{id}',[DepartementController::class, 'updateDepartement']);

// """"""""""""""""""""""Filiere routes #############################"

Route::post('/filieres/add',[FiliereController::class, 'createFiliere']);
Route::get('/filieres',[FiliereController::class, 'getAllFilieres']);
Route::get('/filieres/{id}',[FiliereController::class, 'getFiliereById']);
Route::put('/filieres/{id}',[FiliereController::class, 'updateFiliere']);
Route::delete('/filieres/{id}',[FiliereController::class, 'deleteFiliere']);
Route::get('/filieres/departement/{departement_id}',[FiliereController::class, 'getFilieresByDepartement']);

// """"""""""""""""""""""Document routes #############################"

Route::post('/documents/add',[DocumentController::class, 'createDocument']);
Route::get('/documents/enseignant/{enseignant_id}',[DocumentController::class, 'getDocumentsByEnseignant']);
Route::delete('/documents/{id}',[DocumentController::class, 'deleteDocument']);
Route::get('/documents/{id}',[DocumentController::class, 'getDocument']);
Route::post('/documents/{id}',[DocumentController::class, 'updateDocument']);
});

// """"""""""""""""""""""Annonce routes #############################"
Route::post('/api/annonces/add',[AnnonceController::class, 'createAnnonce']);
Route::get('/api/annonces',[AnnonceController::class, 'getAllAnnonces']);
Route::get('/api/annonces/{id}',[AnnonceController::class, 'getAnnonceById']);
Route::put('/api/annonces/{id}',[AnnonceController::class, 'updateAnnonce']);
Route::delete('/api/annonces/{id}',[AnnonceController::class, 'deleteAnnonce']);
Route::get('/api/annonces/enseignant/{enseignant_id}',[AnnonceController::class, 'getAnnoncesByEnseignant']);

// """"""""""""""""""""""Module routes #############################"
Route::post('/api/modules/add',[ModuleController::class, 'creeModule']);
Route::get('/api/modules',[ModuleController::class, 'getAllModules']);
Route::get('/api/modules/{id}',[ModuleController::class, 'getModuleById']);
Route::put('/api/modules/{id}',[ModuleController::class, 'updateModule']);
Route::delete('/api/modules/{id}',[ModuleController::class, 'deleteModule']);
Route::get('/api/modules/enseignant/{enseignant_id}',[ModuleController::class, 'getModulesByEnseignant']);
Route::get('/api/modules/filiere/{filiere_id}',[ModuleController::class, 'getModulesByFiliere']);

// """"""""""""""""""""""Seance routes #############################"
Route::post('/api/seances/add',[SeanceController::class, 'creeSeance']);
Route::get('/api/seances',[SeanceController::class, 'getAllSeances']);
Route::get('/api/seances/{id}',[SeanceController::class, 'getSeanceById']);
Route::put('/api/seances/{id}',[SeanceController::class, 'updateSeance']);
Route::delete('/api/seances/{id}',[SeanceController::class, 'deleteSeance']);
Route::get('/api/seances/module/{module_id}',[SeanceController::class, 'getSeancesByModule']);

// """"""""""""""""""""""Presence routes #############################"
Route::post('/api/presences/marquer',[App\Http\Controllers\PresenceController::class, 'marquerPresence']);
Route::get('/api/presences/seance/{seance_id}',[App\Http\Controllers\PresenceController::class, 'getPresencesBySeance']);
Route::get('/api/presences/etudiant/{etudiant_id}',[App\Http\Controllers\PresenceController::class, 'getPresencesByEtudiant']);
Route::get('/api/presences',[App\Http\Controllers\PresenceController::class, 'getAllPresences']);
Route::put('/api/presences/{id}',[App\Http\Controllers\PresenceController::class, 'updatePresence']);
Route::get('/api/presences/{id}',[App\Http\Controllers\PresenceController::class, 'getPresenceById']);
Route::delete('/api/presences/{id}',[App\Http\Controllers\PresenceController::class, 'deletePresence']);


