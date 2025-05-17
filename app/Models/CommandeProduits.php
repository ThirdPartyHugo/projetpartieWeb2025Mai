<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandeProduits extends Model
{
    use HasFactory;
    protected $table = 'commandes_produits';
    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable =
    [
        "commande_id",
        "produit_id",
        "qte"
    ];


    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'commande_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'produit_id');
    }
}
