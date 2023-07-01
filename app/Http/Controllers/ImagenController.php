<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Http\Requests\ImagenUploadRequest;
use App\Http\Requests\BanearRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImagenController extends Controller
{
    public function upload(ImagenUploadRequest $imagenUpload)
    {
        $name = time() . '.' . $imagenUpload->archivo->extension();
        $imagenUpload->archivo->move(public_path('images'), $name);

        $imagen = new Imagen();
        $imagen->titulo = $imagenUpload->titulo;
        $imagen->archivo = $name;
        $imagen->baneada = false;
        $imagen->motivo_ban = null;
        $imagen->cuenta_user = Auth::user()->user;
        $imagen->save();

        return redirect()->route('mi_cuenta');
    }

    public function delete(Imagen $imagen)
    {
        $imagen->delete();
        unlink(public_path('images/' . $imagen['archivo']));

        return redirect()->route('mi_cuenta');
    }

    public function update(string $imagen)
    {
        return redirect()->route('mi_cuenta');
    }

    public function banear(BanearRequest $banear, Imagen $imagen)
    {
        $imagen->baneada = true;
        $imagen->motivo_ban = $banear->motivo_ban;
        $imagen->save();

        return redirect()->route('mi_cuenta');
    }

    public function desbanear(Imagen $imagen)
    {
        $imagen->baneada = false;
        $imagen->motivo_ban = null;
        $imagen->save();

        return redirect()->route('mi_cuenta');
    }
}
