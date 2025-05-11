<?php

namespace App\Http\Resources;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $returnArray =
        [
            'commande_id'   => $this->commande_id,
            'commande_total'    => $this->commande_total,
            'commande_date'  => $this->commande_date,
            'statut_id'  => $this->statut_id,
            'produits' => []
        ];

        //produits
        $listProduit = Commande::join("commandes_produits", "commandes.commande_id", "=", "commandes_produits.commande_id")
                                ->where("commandes.commande_id", "=", $this->commande_id)
                                ->get();


        foreach($listProduit as $produit)
        {
            array_push($returnArray["produits"],
            [
                "produit_id" => $produit->produit_id,
                "qte" => $produit->qte
            ]);
        }
        //payement et user
        $payement = Commande::join("payements_users_commandes", "commandes.commande_id", "=", "payements_users_commandes.commande_id")
                                    ->where("commandes.commande_id", "=", $this->commande_id)
                                    ->first();
        $returnArray['payement_id'] = $payement->payement_id;
        $returnArray['user_id'] = $payement->user_id;


        return $returnArray;

    }
}
