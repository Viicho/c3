<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;
    
    protected $table = 'imagenes';

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
}
