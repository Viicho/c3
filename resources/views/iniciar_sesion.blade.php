@extends('layout')

@section('content')
<div class="container-600">
    <div class="shadow p-4 bg-body-tertiary border border-info-subtle rounded">
        <h4 class="text-center">Iniciar sesión</h4>
        <br>
        <form method="post" action="{{route('iniciar_sesion_post')}}">
            @if ($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            @csrf
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="user">
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</div>
@endsection