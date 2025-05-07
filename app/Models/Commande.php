<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    use HasFactory;

    protected $table = "commandes";

    protected $primaryKey = 'commande_id';

    public $timestamps = false;

    public function statut(): BelongsTo
    {
        return $this->belongsTo(Statut::class, 'statut_id', 'statut_id');
    }

}
