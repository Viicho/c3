@extends('layout')

@section('content')
<div class="container-600 mb-5">
    <form action="/">
        <div class="input-group">
            <select class="form-control" name="artista">
                <option value="">Seleccione artista</option>
                @foreach ($artistas_todos as $indexArtista => $artista)
                @if (count($artista['imagenes']))
                <option value="{{$artista['user']}}" {{$artista['user'] == $artista_filtrado ? 'selected' : ''}}>{{$artista['nombre']}} {{$artista['apellido']}}</option>
                @endif
                @endforeach
            </select>
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>
</div>

@if (count($artistas))
<div class="artistas">
    @foreach ($artistas as $indexArtista => $artista)
    @if (count($artista['imagenes']))
    <div>
        <div class="titulo">
            <h5><b>{{$artista['nombre']}}</b> {{$artista['apellido']}}</h5>
            <div>{{count($artista['imagenes'])}} foto{{count($artista['imagenes']) > 1 ? 's' : ''}}</div>
        </div>
        <div id="artista{{$indexArtista}}" class="carousel slide shadow">
            <div class="carousel-inner">
                @foreach ($artista['imagenes'] as $indexImagen => $imagen)
                <div class="carousel-item {{!$indexImagen ? 'active' : ''}}">
                    <img src="{{asset('images/'.$imagen->archivo)}}" class="d-block w-100" alt="{{$imagen['titulo']}}">
                    <div class="carousel-caption d-none d-md-block">
                        <p>{{$imagen['titulo']}}</p>
                    </div>
                </div>
                @endforeach
            </div>

            @if (count($artista['imagenes']) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#artista{{$indexArtista}}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#artista{{$indexArtista}}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
    @endif
    @endforeach
</div>
@else
<div class="container-600 text-center">
    No existen artistas
</div>
@endif
@endsection