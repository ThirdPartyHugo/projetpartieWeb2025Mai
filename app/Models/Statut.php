<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statut extends Model
{
    use HasFactory;
    protected $table = 'statuts';
    protected $primaryKey = 'statut_id';
    public $timestamps = false;

}
