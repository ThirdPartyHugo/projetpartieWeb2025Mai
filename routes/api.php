<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\ModePayementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserIsUser;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(RegisteredUserController::class)->group(function() {
    Route::post('/inscription', 'store')->name('inscriptionAPI');
});

Route::controller(AuthenticatedSessionController::class)->group(function() {
    Route::post('/login', 'store')->name('loginAPI');
});

Route::controller(ProduitController::class)->group(function() {
    Route::get('/produits', 'index')->name('produitsApi');
    Route::delete('/produit/delete', 'destroy')->name('deleteProds');
    Route::get('/produit/filtreName/{text}', 'showFiltreName')->name('showFiltre');
    Route::get('/produit/filtreId/{id}', 'showFiltreId')->name('showFiltre');
    Route::get('/produit/{id}', 'show')->name('produitApi');

});

Route::controller(ProfileController::class)->group(function(){
    Route::post('/modificationProfil', 'update')->name('modificationProfilAPI')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::get('/resetPasswordCourriel', 'envoiCourriel')->name('resetPasswordCourrielAPI')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::get('/searchEmploye', 'search')->name('searchEmploye');
    Route::get('/recupInfoCompte', 'recupInfoCompte')->name('recupInfoCompteAPI')->middleware(['auth:sanctum']);
    Route::get('/supprimeCompte', 'delete')->name('supprimeCompteAPI')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
});

Route::controller(CommandeController::class)->group(function()
{
    Route::get("/commandes", "index")->name("commande.api.index");
    Route::get("/commande/{id}", "show")->name("commande.api.show");
    Route::post("/commandes/add", "store")->name("commande.api.store");
    Route::post("/commandes/update", "edit")->name("commande.api.edit");
    Route::post("/user/commandes", "showByUser")->name("commande.api.showByUser");
});

Route::controller(ModePayementController::class)->group(function()
{
    Route::get("/modepaiement/show", "show")->name("paiement.api.show");
    Route::get("/modepaiement/showAll", "showByUser")->name("paiement.api.showByUser");
    Route::post("/modepaiement/store", "store")->name("paiement.api.store");
    Route::post("/modepaiement/update", "update")->name("paiement.api.update");
    Route::post("/modepaiement/delete", "delete")->name("paiement.api.delete");
    Route::post("/modepaiement/destroy", "destroy")->name("paiement.api.destroy");



});

Route::controller(MagasinController::class)->group(function() {
    Route::get('/magasin', 'index')->name('magasinApi');
});
