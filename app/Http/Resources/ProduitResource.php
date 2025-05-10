<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'produit_id' => $this->produit_id,
            'produit_nom' => $this->produit_nom,
            'produit_description' => $this->produit_description,
            'produit_prix' => $this->produit_prix,
            'produit_image' => $this->produit_image
        ];
    }
}
