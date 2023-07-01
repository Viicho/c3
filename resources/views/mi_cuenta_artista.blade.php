@extends('layout')
@section('content')
@if ($errors->any())
<div class="alert alert-warning">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="imagenes-tab" data-bs-toggle="tab" data-bs-target="#imagenes-tab-pane" type="button" role="tab" aria-controls="imagenes-tab-pane" aria-selected="true">Mis imágenes</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="baneadas-tab" data-bs-toggle="tab" data-bs-target="#baneadas-tab-pane" type="button" role="tab" aria-controls="baneadas-tab-pane" aria-selected="false">Imágenes baneadas</button>
    </li>
</ul>
<div class="tab-content">
    <!-- TAB Lista de imágenes -->
    <div class="tab-pane fade p-2 pt-3 show active" id="imagenes-tab-pane" role="tabpanel" aria-labelledby="imagenes-tab" tabindex="0">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalUpload">Subir nueva imagen</button>
        <div class="text-center d-flex flex-wrap justify-content-center gap-1">
            @foreach ($imagenes as $indexImagen => $imagen)
            @if (!$imagen['baneada'])
            <div class="imagen shadow-sm">
                <img src="{{asset('images/'.$imagen['archivo'])}}" />
                <div>
                    <div class="d-flex gap-1">
                        <span data-bs-toggle="tooltip" data-bs-title="Editar título">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditar{{$indexImagen}}"><i class="bi bi-pencil"></i></button>
                        </span>
                        <span data-bs-toggle="tooltip" data-bs-title="Eliminar imagen">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$indexImagen}}"><i class="bi bi-trash"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- TAB Imágenes baneadas -->
    <div class="tab-pane fade p-2 pt-3" id="baneadas-tab-pane" role="tabpanel" aria-labelledby="baneadas-tab" tabindex="1">
        <div class="text-center d-flex flex-wrap justify-content-center gap-1">
            @foreach ($imagenes as $indexImagen => $imagen)
            @if ($imagen['baneada'])
            <div class="imagen shadow-sm">
                <img src="{{asset('images/'.$imagen['archivo'])}}" />
                <div>
                    <div class="d-flex gap-1">
                        <span data-bs-toggle="tooltip" data-bs-title="Ver motivo baneo">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBaneada{{$indexImagen}}"><i class="bi bi-eye"></i></button>
                        </span>
                        <span data-bs-toggle="tooltip" data-bs-title="Eliminar imagen">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$indexImagen}}"><i class="bi bi-trash"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR TITULO -->
@foreach ($imagenes as $indexImagen => $imagen)
@if (!$imagen['baneada'])
<div class="modal fade" id="modalEditar{{$indexImagen}}" tabindex="-1" aria-labelledby="modalEditarLabel{{$indexImagen}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('imagen_update', $imagen['id'])}}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditarLabel{{$indexImagen}}">{{$imagen['titulo']}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="titulo" class="form-label">Ingrese nuevo título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- MODAL PARA ELIMINAR IMAGEN -->
@foreach ($imagenes as $indexImagen => $imagen)
<div class="modal fade" id="modalEliminar{{$indexImagen}}" tabindex="-1" aria-labelledby="modalEliminar{{$indexImagen}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('imagen_delete', $imagen['id'])}}">
                @method('delete')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEliminar{{$indexImagen}}">Eliminar imagen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Confirma la eliminación de la imagen con título <b>{{$imagen['titulo']}}</b>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA SUBIR IMAGEN -->
<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('imagen_upload')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUploadLabel">Subir nueva imagen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="archivo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA VISUALIZAR IMAGEN BANEADA -->
@foreach ($imagenes as $indexImagen => $imagen)
@if ($imagen['baneada'])
<div class="modal fade" id="modalBaneada{{$indexImagen}}" tabindex="-1" aria-labelledby="modalBaneadaLabel{{$indexImagen}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalBaneadaLabel{{$indexImagen}}">{{$imagen['titulo']}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('images/'.$imagen['archivo'])}}" class="img-fluid" />
                <div class="mt-3">
                    <label class="mb-2 fw-bold">Motivo baneo</label>
                    <div>{{$imagen['motivo_ban']}}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection