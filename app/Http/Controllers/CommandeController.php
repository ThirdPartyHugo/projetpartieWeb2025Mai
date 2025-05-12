<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use App\Models\CommandeProduits;
use App\Models\ModePayement;
use App\Models\ModePayementUserCommande;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\Produit;
use App\Models\Statut;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $commandes = Commande::all();

        if(is_null($commandes))
        {
            return abort(404, "Aucune commande enregistrée");
        }


        if ($request->routeIs('commande.index'))
        {
            if (is_null($commandes))
            {
                return abort(404, "Aucune commande enregistée");
            }


            $commandes = ModePayementUserCommande::all();

            return view("commande/listCommandes",
            [
                "commandes" => $commandes
            ]);
        }
        else if ($request->routeIs('commande.api.index'))
        {
            if (empty($commandes))
            {
                return response()->json(['ERREUR' => 'Les commandes sont introuvables.'], 400);
            }
            return CommandeResource::collection($commandes);
        }
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
    public function store(Request $request)
    {
        $rawContent = $request->all();

        if(gettype($rawContent["payement_method"]) == "array")
        {

            $card = ModePayement::where("payement_no_carte", "LIKE", $rawContent["payement_method"]["no_carte"])
                    ->first();


            //check si il existe
            if(!is_null($card))
            {

                if($card->payement_expiration != $rawContent["payement_method"]["expiration"])
                {
                    return response()->json(['ERREUR' => 'La date d\'expiration de la carte entrée ne correspond pas à celle enregistrée.'], 500);
                }
                else
                {
                    $rawContent["payement_method"] = $card->payement_id;
                }
            }
            else
            {
                $insertCard = new ModePayementController;
                $payementIndex = $insertCard->store($rawContent["payement_method"]);

                if($payementIndex == -1)
                {
                    return response()->json(['ERREUR' => 'Erreur à l\'insertion du mode de paiement lors de la création de la commande.'], 500);
                }
                else
                {
                    $rawContent["payement_method"] = $payementIndex;
                }
            }
        }
        elseif(is_null(ModePayement::find("payement_method")))
        {
            return response()->json(['ERREUR' => "L'ID du mode de payement entrée n'existe pas"], 400);
        }

        $validation = Validator::make($rawContent,
        [
            "user_id" => "required",
            "payement_method" => "required|numeric",
            "produits" => "required"
        ],
        [
            "user_id.required" => "L'ID de l'utilisateur est nécessaire",
            "payement_method.required" => "Le mode de paiement est nécessaire",
            "payement_method.numeric" => "Un ID du mode de paiment est nécessaire",
            "produits.required" => "Une liste de produits est nécessaire"

        ]);
        if ($validation->fails())
        {
            return response()->json(['ERREUR' => $validation->errors()], 400);
        }
        $content = $validation->validated();


        $user_id = $content["user_id"];

        $commande = new Commande;

        $commande->commande_date = date('Y/m/d h:i:s', time());
        $total = 0;
        $commande->statut_id = 1; //pending



        foreach ($content["produits"] as $produit_id => $qte)
        {
            $total += Produit::find($produit_id)->produit_prix * $qte;
        }


        $commande->commande_total = $total;

        $state = $commande->save();


        if($state)
        {

            $id = $commande->commande_id;

            try
            {


                foreach ($content["produits"] as $produit_id => $qte)
                {

                    $commandeProduits = new CommandeProduits;

                    $commandeProduits->commande_id = $id;

                    $commandeProduits->produit_id = $produit_id;
                    $commandeProduits->qte = $qte;



                    if(!$commandeProduits->save())
                    {
                        throw new Exception("La sauvegarde de la transaction avec le produit no " + $produit_id + "a échouée");
                    }
                }
                $payementUserCommande = new ModePayementUserCommande;

                $payementUserCommande->commande_id = $id;
                $payementUserCommande->user_id = $user_id;
                $payementUserCommande->payement_id = $content["payement_method"];

                if(!$payementUserCommande->save())
                {
                    throw new Exception("La sauvegarde de la transaction avec la methode de paiement no " + $content["payement_method"] + "a échouée");
                }
            }
            catch(QueryException $erreur)
            {
                return response()->json(['ERREUR' => $erreur->getMessage()], 500);
                $this->cancelTransaction($id);
            }
            catch(Exception $erreur)
            {
                return response()->json(['ERREUR' => 'Erreur critique à la sauvegarde d\'une insertion.\n
                Transaction annulée.'], 500);

                $this->cancelTransaction($id);
            }

            return response()->json(['SUCCES' => 'La commande a été ajoutée.'], 200);

        }
        else
        {
            return response()->json(['ERREUR' => 'Erreur à l\'insertion de la commande.'], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $commande = Commande::find($request->id);

        if(is_null($commande))
        {
            return abort(404);
        }

        if ($request->routeIs('commande.show'))
        {
            if (is_null($commande))
            {
                return abort(404);
            }

            return view("commande/commande",
            [
                "commande" => $commande
            ]);
        }
        else if ($request->routeIs('commande.api.show'))
        {
            if (empty($commande))
            {
                return response()->json(['ERREUR' => 'La commande demandée est introuvable.'], 400);
            }
            return response()->json(['SUCCES' => new CommandeResource($commande)], 200);
        }
    }

    public function showByUser(Request $request)
    {

        $commandes = Commande::join("payements_users_commandes", "commandes.commande_id", "=", "payements_users_commandes.commande_id")
                            ->where("payements_users_commandes.user_id", "=", $request->user_id)
                            ->get();

        if(is_null($commandes))
        {
            return abort(404);
        }

        if ($request->routeIs('commande.show'))
        {
            if (is_null($commandes))
            {
                return abort(404);
            }

            return view("commande/commande",
            [
                "commandes" => $commandes
            ]);
        }
        else if ($request->routeIs('commande.api.showByUser'))
        {
            if (empty($commandes))
            {
                return abort(501);

                return response()->json(['ERREUR' => 'La commande demandée est introuvable.'], 400);
            }

            return response()->json(['SUCCES' => CommandeResource::collection($commandes)], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request )
    {
        return view("commande/editCommande",
        [
            "commande" => Commande::find($request->input('commande_id')),
            "statuts" => Statut::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "commande_id" => "required",
            "statut_id" => "required"
        ],
        [
            "commande_id.required" => "Aucune commande n'a été selectionnée",
            "statut_id.required" => "Le statut de la commande est manquante"
        ]);

        if($validation->fails())
        {
            return back()->withErrors($validation->errors())->withInput();
        }
        else
        {
            //c'est ok de l'enregistrer en clair ?
            $content = $validation->validated();

            $commande = Commande::find($content["commande_id"]);

            $commande->statut_id = $content["statut_id"];

            if($commande->save())
            {
                session()->flash("succès", "La modification de la commande a bien fonctionnée");
            }
            else
            {
                session()->flash("erreur", "La modification de la commande n'a pas fonctionnée");
            }

            return redirect()->route('commande.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input("id");

        if(Commande::destroy($id))
        {
            return back()->with("succès", "La suppression de la commande a bien fonctionnée.");
        }

        return back()->with("erreur", "La suppression de la commande n'a pas fonctionné.");


    }

    //permer de supprimer toute les transaction contenu dans params
    public function cancelTransaction($commande_id)
    {
        Commande::destroy($commande_id);
    }
}
