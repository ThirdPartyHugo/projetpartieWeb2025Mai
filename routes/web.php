<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MagasinController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsNotUser;
use App\Http\Middleware\EnsureUserIsUser;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(EnsureUserIsNotUser::class)->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::controller(ProduitController::class)->group(function () {
            Route::get('/produits', 'index')->name('produits');
            Route::get('/produit/{id}/modification', 'edit')->name('modificationProduit');
            Route::post('/enregistrementProduits', 'update')->name('enregistrementProduit');
            Route::get('/produit/ajout', 'create')->name("ajouterProduit");
            Route::post( '/produits', 'store')->name('storeProduit');
        });

        Route::controller(ProfileController::class)->middleware(EnsureUserIsAdmin::class)->group(function () {
            Route::get('/listEmployee', 'list')->name('listEmployee');
            Route::post('/listeEmployee', 'delete')->name('deleteEmployee');
            Route::get('/ajoutEmployee', 'showRegister')->name('ajoutUser');
            Route::post('/addEmployee', [RegisteredUserController::class, 'store'])->name('ajoutEmployee');
            Route::post('/updateEmployee', 'update')->name('updateEmployee');
            Route::post('/deleteEmployee', 'delete')->name('deleteEmployee');
        });

        Route::controller(MagasinController::class)->group(function () {
            Route::get('/magasins', 'index')->name('magasins');
            Route::get('/magasin/{id}/modification', 'edit')->name('modificationMagasin');
            Route::post('/enregistrementMagasins', 'update')->name('enregistrementMagasin');
            Route::get('/ajoutMagasin', 'create')->name("ajouterMagasin");
            Route::post( '/magasins', 'store')->name('storeMagasin');
        });
    });
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/resetPassword/{id}', 'formReset')->name('formResetPassword');
    Route::post('/updatePassword', 'updatePassword')->name('updatePassword');
});

Route::controller(CommandeController::class)->group(function ()
{
    Route::get("/commandes", "index")->name("commande.index");
    Route::get("/commande","show")->name("commande.show");
    Route::get("/commande/edit/", "edit")->name("commande.edit");
    Route::post("/commande/update", "update")->name("commande.update");
    Route::post("/commande/delete", "destroy")->name("commande.destroy");
});

require __DIR__.'/auth.php';
