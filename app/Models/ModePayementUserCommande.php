<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModePayementUserCommande extends Model
{
    use HasFactory;

    protected $table = "payements_users_commandes";
    public $timestamps = false;


    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'commande_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mode_payement(): BelongsTo
    {
        return $this->belongsTo(ModePayement::class, 'payement_id', 'payement_id');
    }
}
