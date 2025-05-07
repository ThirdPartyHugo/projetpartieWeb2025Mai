<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Magasin extends Model
{
    use HasFactory;
    protected $table = 'magasins';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
