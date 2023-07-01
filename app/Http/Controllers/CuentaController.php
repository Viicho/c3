<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Http\Requests\CuentaNuevaRequest;
use App\Http\Requests\CuentaEditarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CuentaController extends Controller
{
    public function create(CuentaNuevaRequest $cuentaNueva)
    {
        $cuenta = new Cuenta();
        $cuenta->user = $cuentaNueva->user;
        $cuenta->password = Hash::make($cuentaNueva->password);
        $cuenta->nombre = $cuentaNueva->nombre;
        $cuenta->apellido = $cuentaNueva->apellido;
        $cuenta->perfil_id = $cuentaNueva->perfil_id;
        $cuenta->save();

        return redirect()->route('mi_cuenta');
    }

    public function update(CuentaEditarRequest $cuentaEditar, Cuenta $cuenta)
    {
        $cuenta->nombre = $cuentaEditar->nombre;
        $cuenta->apellido = $cuentaEditar->apellido;
        $cuenta->save();

        return redirect()->route('mi_cuenta');
    }

    public function delete(Cuenta $cuenta)
    {
        $cuenta->delete();

        return redirect()->route('mi_cuenta');
    }
}
