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
Route::get('/users/me',[UserController::class, 'me']);

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

// """"""""""""""""""""""Annonce routes #############################"
Route::post('/annonces/add',[AnnonceController::class, 'createAnnonce']);
Route::get('/annonces',[AnnonceController::class, 'getAllAnnonces']);
Route::get('/annonces/{id}',[AnnonceController::class, 'getAnnonceById']);
Route::put('/annonces/{id}',[AnnonceController::class, 'updateAnnonce']);
Route::delete('/annonces/{id}',[AnnonceController::class, 'deleteAnnonce']);
Route::get('/annonces/enseignant/{enseignant_id}',[AnnonceController::class, 'getAnnoncesByEnseignant']);

// """"""""""""""""""""""Module routes #############################"
Route::post('/modules/add',[ModuleController::class, 'creeModule']);
Route::get('/modules',[ModuleController::class, 'getAllModules']);
Route::get('/modules/{id}',[ModuleController::class, 'getModuleById']);
Route::put('/modules/{id}',[ModuleController::class, 'updateModule']);
Route::delete('/modules/{id}',[ModuleController::class, 'deleteModule']);
Route::get('/modules/enseignant/{enseignant_id}',[ModuleController::class, 'getModulesByEnseignant']);
Route::get('/modules/filiere/{filiere_id}',[ModuleController::class, 'getModulesByFiliere']);

// """"""""""""""""""""""Seance routes #############################"
Route::post('/seances/add',[SeanceController::class, 'creeSeance']);
Route::get('/seances',[SeanceController::class, 'getAllSeances']);
Route::get('/seances/{id}',[SeanceController::class, 'getSeanceById']);
Route::put('/seances/{id}',[SeanceController::class, 'updateSeance']);
Route::delete('/seances/{id}',[SeanceController::class, 'deleteSeance']);
Route::get('/seances/module/{module_id}',[SeanceController::class, 'getSeancesByModule']);

// """"""""""""""""""""""Presence routes #############################"
Route::post('/presences/marquer',[App\Http\Controllers\PresenceController::class, 'marquerPresence']);
Route::get('/presences/seance/{seance_id}',[App\Http\Controllers\PresenceController::class, 'getPresencesBySeance']);
Route::get('/presences/etudiant/{etudiant_id}',[App\Http\Controllers\PresenceController::class, 'getPresencesByEtudiant']);
Route::get('/presences',[App\Http\Controllers\PresenceController::class, 'getAllPresences']);
Route::put('/presences/{id}',[App\Http\Controllers\PresenceController::class, 'updatePresence']);
Route::get('/presences/{id}',[App\Http\Controllers\PresenceController::class, 'getPresenceById']);
Route::delete('/presences/{id}',[App\Http\Controllers\PresenceController::class, 'deletePresence']);
});

// Public presence scanning endpoint (students can scan without full authentication)
Route::post('/api/presences/marquer',[App\Http\Controllers\PresenceController::class, 'marquerPresence']);


