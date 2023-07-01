@extends('layout')

@section('content')
<div class="container-600">
    <div class="shadow p-4 bg-body-tertiary border border-info-subtle rounded">
        <h4 class="text-center">Crear cuenta</h4>
        <br>
        <form method="post" action="{{route('crear_cuenta_post')}}">
            @if ($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido">
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="user">
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Crear cuenta</button>
        </form>
    </div>
</div>
@endsection