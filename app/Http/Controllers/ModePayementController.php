<?php

namespace App\Http\Controllers;

use App\Models\ModePayement;
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
            //return back()->withErrors($validation->errors())->withInput();
            return false;
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
    public function show(ModePayement $modePayement)
    {
        //
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
            "id" => "required",
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

            $modePayement = ModePayement::find($content["id"]);

            $modePayement->payement_no_carte = $content["no_carte"];
            $modePayement->payement_expiration = $content["expiration"];
            $modePayement->payement_nip = $content["nip"];

            if($modePayement->save())
            {
                session()->flash("succès", "La modification du mode de payement a bien fonctionnée");
            }
            else
            {
                session()->flash("erreur", "La modification du mode de payement n'a pas fonctionnée");
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

        if(ModePayement::destroy($id))
        {
            return back()->with("succès", "La suppression du mode de payement a bien fonctionnée.");
        }

        return back()->with("erreur", "La suppression du mode de payement n'a pas fonctionné.");


    }
}
