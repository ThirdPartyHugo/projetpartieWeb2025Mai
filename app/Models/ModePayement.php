<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModePayement extends Model
{
    use HasFactory;

    protected $table = "modes_payements";
    protected $primaryKey = 'payement_id';
    public $timestamps = false;

    protected $fillable =
    [
        "payement_no_carte",
        "payement_expiration"
    ];
}
