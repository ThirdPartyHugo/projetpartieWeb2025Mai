<?php

namespace App\Http\Controllers;

use App\Models\ModePayement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModePayementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($params)
    {
        $validation = Validator::make($params,
        [
            "no_carte" => "required|regex:/^\d{16}$/",
            "expiration" => "required"
        ],
        [
            "no_carte.regex" => "Veuillez entrer la carte au complet",
            "no_carte.required" => "Veuillez indiquer une carte de crédit",
            "expiration.required" => "Veuillez remplir le champ d'expiration",
        ]);

        if($validation->fails())
        {
            return back()->withErrors($validation->errors())->withInput();
        }
        else
        {
            $content = $validation->validated();

            $modePayement = new ModePayement();

            $modePayement->payement_no_carte = $content["no_carte"];             //c'est ok de l'enregistrer en clair ?
            $modePayement->payement_expiration = $content["expiration"];

            if($modePayement->save())
            {
                return $modePayement->payement_id;
            }
            else
            {
                return -1;
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $modepaiement = ModePayement::join("payements_users_commandes","modes_payements.payement_id", "=", "payements_users_commandes.payement_id")
                                    ->where("payements_users_commandes.user_id", "=", $request->user_id)
                                    ->where("modes_payements.payement_id", "=", $request->payement_id)
                                    ->first();

        if($request->routeIs("paiement.api.show"))
        {
            if (!$modepaiement)
            {
                return response()->json(['ERREUR' => 'Le mode de paiement demandé est introuvable.'], 400);
            }
            return response()->json(['SUCCES' => $modepaiement], 200);
        }
    }

    public function showByUser(Request $request)
    {
        $listPayement = ModePayement::join("payements_users_commandes","modes_payements.payement_id", "=", "payements_users_commandes.payement_id")
                        ->where("payements_users_commandes.user_id", "=", $request->user_id)
                        ->get();

        if($request->routeIs("paiement.api.showByUser"))
        {
            if(!isset($listPayement[1]))
            {
                return response()->json(['ERREUR' => 'Aucun mode de payement liee à ce user.'], 400);
            }
            return response()->json(['SUCCES' => $listPayement], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModePayement $modePayement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "payement_id" => "required",
            "no_carte" => "required|regex:/^\d{16}$/",
            "expiration" => "required"
        ],
        [
            "id.required" => "Veuillez indiquer la méthode de payement à modifier",
            "no_carte.required" => "Veuillez indiquer une carte",
            "no_carte.regex" => "Veuillez entrer la carte au complet",
            "expiration.required" => "Veuillez indiquer la date d'éxpiration",
        ]);

        if($validation->fails())
        {
            return back()->withErrors($validation->errors())->withInput();
        }
        else
        {
            //c'est ok de l'enregistrer en clair ?
            $content = $validation->validated();

            $modePayement = ModePayement::find($content["paiement_id"]);

            $modePayement->payement_no_carte = $content["no_carte"];
            $modePayement->payement_expiration = $content["expiration"];


            $saved = $modePayement->save();

            if($request->routeIs("paiement.api.update"))
            {
                if($saved)
                {
                    return response()->json(['SUCCES' => 'La modification du mode de payement a bien fonctionnee.'], 400);
                }
                else
                {
                    return response()->json(['ERREUR' => 'Aucun mode de payement liee à ce user.'], 400);
                }
            }

            if($saved)
            {
                session()->flash("SUCCES", "La modification du mode de payement a bien fonctionnee");
            }
            else
            {
                session()->flash("ERREUR", "La modification du mode de payement n'a pas fonctionnee");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * On devrait plutot "desactiver" le champ mode de payement, nn ?
     */
    public function destroy(Request $request)
    {
        $id = $request->input("id");

        $destroyed = ModePayement::destroy($id);

        if($request->routeIs("paiement.api.destroy"))
        {
            if($destroyed)
            {
                return response()->json(['SUCCES' => 'La destruction du mode de payement a bien fonctionnee.'], 400);
            }
            else
            {
                return response()->json(['ERREUR' => "La destruction du mode de payement n'a pas fonctionnee."], 500);
            }
        }


        if($destroyed)
        {
            return back()->with("SUCCES", "La destruction du mode de payement a bien fonctionnee.");
        }

        return back()->with("ERREUR", "La destruction du mode de payement n'a pas fonctionnee.");


    }

    public function delete(Request $request)
    {
        $modePayement = ModePayement::find($request->payement_id);

        $modePayement->deleted = true;
        $saved = $modePayement->save();

        if($request->routeIs("paiement.api.delete"))
        {
            if($saved)
            {
                return response()->json(['SUCCES' => 'La suppression du mode de payement a bien fonctionnee.'], 400);
            }
            else
            {
                return response()->json(['ERREUR' => "La suppression du mode de payement n'a pas fonctionnee."], 500);
            }

        }
        if($saved)
        {
            return back()->with("SUCCES", "La suppression du mode de payement a bien fonctionnee.");
        }

        return back()->with("ERREUR", "La suppression du mode de payement n'a pas fonctionnee.");

    }
}
