<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Produit extends Model
{
    use HasFactory;
    protected $table = 'produits';
    protected $primaryKey = 'produit_id';
    public $timestamps = false;
    protected $fillable = [ 'produit_nom', 'produit_description', 'produit_prix', 'produit_image'];

}
