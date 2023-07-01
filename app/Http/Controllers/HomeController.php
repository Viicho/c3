<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Perfil;
use App\Models\Imagen;
use App\Http\Requests\CuentaCrearRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // Todos los artistas
        $artistas_todos = Cuenta::where('perfil_id', 2)->get();

        // Artistas filtrados
        $artistas = Cuenta::where('perfil_id', 2);
        if ($request->artista) $artistas = $artistas->where('user', $request->artista);
        $artistas = $artistas->get();

        // Eliminar imagenes baneadas
        foreach ($artistas as $artista) {
            $imagenes = [];
            foreach ($artista['imagenes'] as $imagen) {
                if (!$imagen['baneada']) $imagenes[] = $imagen;
            }
            $artista['imagenes'] = $imagenes;
        }

        // Artista filtrado
        $artista_filtrado = $request->artista;

        // Usuario de la sesion
        $user = Auth::user();

        return view('home', compact('artistas_todos', 'artistas', 'artista_filtrado', 'user'));
    }

    public function iniciar_sesion()
    {
        return view('iniciar_sesion');
    }

    public function iniciar_sesion_post(Request $request)
    {
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('mi_cuenta');
        } else {
            return back()->withErrors([
                'user' => 'Credenciales incorrectas'
            ]);
        }
    }

    public function crear_cuenta()
    {
        return view('crear_cuenta');
    }

    public function crear_cuenta_post(CuentaCrearRequest $request)
    {
        $cuenta = new Cuenta();
        $cuenta->user = $request->user;
        $cuenta->password = Hash::make($request->password);
        $cuenta->nombre = $request->nombre;
        $cuenta->apellido = $request->apellido;
        $cuenta->perfil_id = 2;
        $cuenta->save();

        Auth::login($cuenta);

        $user = Auth::user();

        return redirect()->route('mi_cuenta');
    }

    public function cerrar_sesion(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function mi_cuenta()
    {
        // Admin
        if (Auth::user()->perfil_id === 1) {
            $perfiles = Perfil::all();
            $cuentas = Cuenta::all();
            $imagenes = Imagen::all();

            $user = Auth::user();

            return view('mi_cuenta_admin', compact('perfiles', 'cuentas', 'imagenes', 'user'));
        }

        // Artista
        if (Auth::user()->perfil_id === 2) {
            $imagenes = Imagen::where('cuenta_user', Auth::user()['user'])->get();

            $user = Auth::user();

            return view('mi_cuenta_' . ['admin', 'artista'][Auth::user()->perfil_id - 1], compact('imagenes', 'user'));
        }
    }
}
