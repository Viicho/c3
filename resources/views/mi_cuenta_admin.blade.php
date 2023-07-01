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
        <button class="nav-link active" id="imagenes-tab" data-bs-toggle="tab" data-bs-target="#imagenes-tab-pane" type="button" role="tab" aria-controls="imagenes-tab-pane" aria-selected="true">Lista de imágenes</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="cuentas-tab" data-bs-toggle="tab" data-bs-target="#cuentas-tab-pane" type="button" role="tab" aria-controls="cuentas-tab-pane" aria-selected="false">Lista de cuentas</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="perfiles-tab" data-bs-toggle="tab" data-bs-target="#perfiles-tab-pane" type="button" role="tab" aria-controls="perfiles-tab-pane" aria-selected="false">Lista de perfiles</button>
    </li>
</ul>
<div class="tab-content">
    <!-- TAB Lista de imágenes -->
    <div class="tab-pane fade p-2 pt-3 show active" id="imagenes-tab-pane" role="tabpanel" aria-labelledby="imagenes-tab" tabindex="0">
        <div class="text-center d-flex flex-wrap justify-content-center gap-1">
            @foreach ($imagenes as $indexImagen => $imagen)
            @if ($imagen['baneada'])
            <div class="imagen shadow-sm baneada">
                <img src="{{asset('images/'.$imagen['archivo'])}}" />
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBan{{$indexImagen}}">Desbanear</button>
                </div>
            </div>
            @else
            <div class="imagen shadow-sm">
                <img src="{{asset('images/'.$imagen['archivo'])}}" />
                <div>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalBan{{$indexImagen}}">Banear</button>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- TAB Lista de cuentas -->
    <div class="tab-pane fade p-2 pt-3" id="cuentas-tab-pane" role="tabpanel" aria-labelledby="cuentas-tab" tabindex="1">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCuentaCrear">Crear cuenta nueva</button>
        <table class="table border-top border-2">
            <thead class="table-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Perfil</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuentas as $indexCuenta => $cuenta)
                <tr>
                    <td>{{$cuenta['nombre']}}</td>
                    <td>{{$cuenta['apellido']}}</td>
                    <td>{{$cuenta['perfil']['nombre']}}</td>
                    <td class="text-end">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCuentaEditar{{$indexCuenta}}">Editar</button>
                        @if ($cuenta['user'] !== $user['user'])
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCuentaEliminar{{$indexCuenta}}">Eliminar</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- TAB Lista de perfiles -->
    <div class="tab-pane fade p-2 pt-3" id="perfiles-tab-pane" role="tabpanel" aria-labelledby="perfiles-tab" tabindex="2">
        <table class="table border-top border-2">
            <thead class="table-light">
                <tr>
                    <th scope="col">Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($perfiles as $indexPerfil => $perfil)
                <tr>
                    <td>{{$perfil['nombre']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL PARA BANEAR Y DESBANEAR -->
@foreach ($imagenes as $indexImagen => $imagen)
@if ($imagen['baneada'])
<div class="modal fade" id="modalBan{{$indexImagen}}" tabindex="-1" aria-labelledby="modalBanLabel{{$indexImagen}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('desbanear', $imagen['id'])}}">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalBanLabel{{$indexImagen}}">{{$imagen['titulo']}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('images/'.$imagen['archivo'])}}" class="img-fluid" />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Desbanear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="modal fade" id="modalBan{{$indexImagen}}" tabindex="-1" aria-labelledby="modalBanLabel{{$indexImagen}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('banear', $imagen['id'])}}">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalBanLabel{{$indexImagen}}">{{$imagen['titulo']}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('images/'.$imagen['archivo'])}}" class="img-fluid" />
                    <div class="mt-3">
                        <label for="motivo_ban" class="form-label">Ingrese motivo</label>
                        <input type="text" class="form-control" id="motivo_ban{{$indexImagen}}" name="motivo_ban">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Banear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- MODAL CUENTA EDITAR -->
@foreach ($cuentas as $indexCuenta => $cuenta)
<div class="modal fade" id="modalCuentaEditar{{$indexCuenta}}" tabindex="-1" aria-labelledby="modalCuentaEditarLabel{{$indexCuenta}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('cuenta_update', $cuenta['user'])}}">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCuentaEditarLabel{{$indexCuenta}}">Editar cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre_cuenta{{$indexCuenta}}" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_cuenta{{$indexCuenta}}" name="nombre" value="{{$cuenta['nombre']}}">
                    </div>
                    <div class="mb-3">
                        <label for="apellido_cuenta{{$indexCuenta}}" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido_cuenta{{$indexCuenta}}" name="apellido" value="{{$cuenta['apellido']}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL CUENTA ELIMINAR -->
@foreach ($cuentas as $indexCuenta => $cuenta)
<div class="modal fade" id="modalCuentaEliminar{{$indexCuenta}}" tabindex="-1" aria-labelledby="modalCuentaEliminarLabel{{$indexCuenta}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('cuenta_delete', $cuenta['user'])}}">
                @method('delete')
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCuentaEliminarLabel{{$indexCuenta}}">Eliminar cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Confirma la eliminación de la cuenta de <b>{{$cuenta['nombre']}} {{$cuenta['apellido']}}</b>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL CUENTA CREAR -->
<div class="modal fade" id="modalCuentaCrear" tabindex="-1" aria-labelledby="modalCuentaCrearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('cuenta_create')}}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCuentaCrearLabel">Crear cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre_cuenta" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_cuenta" name="nombre">
                    </div>
                    <div class="mb-3">
                        <label for="apellido_cuenta" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido_cuenta" name="apellido">
                    </div>
                    <div class="mb-3">
                        <label for="usuario_cuenta" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario_cuenta" name="user">
                    </div>
                    <div class="mb-3">
                        <label for="contrasena_cuenta" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena_cuenta" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="perfil_cuenta" class="form-label">Perfil</label>
                        <select class="form-select" id="perfil_cuenta" aria-label="Seleccione" name="perfil_id">
                            <option value="">Seleccione perfil</option>
                            @foreach ($perfiles as $indexPerfil => $perfil)
                            <option value="{{$perfil['id']}}">{{$perfil['nombre']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection