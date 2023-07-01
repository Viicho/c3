<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cuenta extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuentas';
    protected $primaryKey = 'user';
    protected $keyType = 'string';
    public $incrementing = false;

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
}
