<?php

namespace App\Http\Resources;

use App\Models\Produit;
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

        return
        [
            'commande_id'   => $this->commande_id,
            'commande_total'    => $this->commande_total,
            'commande_date'  => $this->commande_date,
            'statut_id'  => $this->statut_id,
        ];
    }
}
