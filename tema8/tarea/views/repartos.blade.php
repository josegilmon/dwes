@extends('app')
@section('encabezado', "Listado de Repartos")
@section('contenido')
<h4 class="text-center mt-3">Gestión de Repartos</h4>
<div class="container mt-4" style='width:80rem;'>
    <form action='index.php' method='POST'>
        <div class="row">
            <div class="col-md-3 mb-2">
                <button type='submit' name='nueva-lista-repartos' class="btn btn-info"><i class='fas fa-plus mr-1'></i>Nueva Lista de Reparto</button>
            </div>
            <div class="col-md-4">
                <!--input type=text class="form form-control" id="title" name="nombre" placeholder='Lista de Reparto' required-->
                <input type="date" class="form form-control" id="date" name="fecha" min="{{$fechaMinima}}" required>
            </div>
        </div>
        @if(isset($error))
            <div class="row text-danger">{{$error}}</div> 
        @endif
    </form>
    @foreach ($listasReparto as $listaReparto) 
    <table class='table mt-2'>
        <thead class='bg-secondary'>
            <tr>
                <th scope='col' style='width:42rem;'>{{ $listaReparto->getNombre() }}</th>
                <th scope='col' class='text-right'>
                    <form action="index.php" method="POST" id="acciones-lr">
                        <div class="btn-group" role="group">
                            <input type="hidden" name="lista-reparto-id" value="{{ $listaReparto->getId() }}">
                            <button type="submit" name="pet-nuevo-reparto" class='btn btn-info mr-2 btn-sm'><i class='bi bi-plus mr-1'></i>Nuevo</button>
                            <button class='btn btn-success mr-2 btn-sm ordenar'><i class='bi bi-sort-down mr-1'></i>ordenar</button>
                            <button type="submit" name="borra-lista-reparto" class='btn btn-danger btn-sm' onclick="return confirm('¿Borrar Lista?')"><i class='bi bi-trash mr-1'></i>Borrar</button>
                        </div>
                    </form>
                </th>
            </tr>
        </thead>
        <tbody id="{{ $listaReparto->getId() }}" style='font-size:0.8rem'>
            <tr>
                <td class="text-center">
                    <form action="index.php" method="POST" id="acciones-lr">
                        <input type="hidden" name="lista-reparto-id" value="{{ $listaReparto->getId() }}">
                        <button type="submit" name="mapa-ruta" class='btn btn-info ml-2 btn-sm'><i class='bi bi-geo-alt-fill'></i>Mapa Ruta</button>
                    </form>
                </td>
            </tr>
            @foreach ($listaReparto->getRepartos() as $reparto)
            <tr id="{{ $listaReparto->getId() }}-{{ $reparto->getId() }}">
                <td scope='row' class="fw-bold">{{ "{$reparto->getProducto()}, {$reparto->getDireccion()}" }} ({{ "{$reparto->getLat()}, {$reparto->getLon()}" }})</td>
                <input type='hidden' value='{{ "{$reparto->getLat()}, {$reparto->getLon()}" }}'>
                <td scope='row' class='text-right'>
                    <form action="index.php" method="POST" id="acciones-lr">
                        <div class="btn-group" role="group">
                            <input type="hidden" name="lista-reparto-id" value="{{ $listaReparto->getId() }}">
                            <input type="hidden" name="reparto-id" value="{{ $reparto->getId() }}">
                            <input type='hidden' name="lat" value="{{ $reparto->getLat() }}">
                            <input type='hidden' name="lon" value="{{ $reparto->getLon() }}">
                            <button type="submit" name="borra-reparto" class='btn btn-danger btn-sm' onclick="return confirm('¿Borrar reparto?')"><i class='bi bi-trash mr-1'></i>Borrar</a></button>
                            <button type="submit" name="mapa-reparto" class='btn btn-info ml-2 btn-sm'><i class='bi bi-geo-alt-fill'></i>Mapa</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</div>
@endsection
@section('scripts')
<script src="js/ordenar.js"></script>
@endsection