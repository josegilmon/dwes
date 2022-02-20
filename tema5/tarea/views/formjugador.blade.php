@extends('app')
@section('titulo', "Crear Jugador")
@section('encabezado', "Crear Jugador")
@section('contenido')

<div class="container">

@if(!empty($error)) 
    <div class="my-3 p-3 bg-danger">
        {{$error}}
    </div>
    @endif

    <form action="{{$_SERVER['PHP_SELF']}}" method="POST">
        <div class="row">
            <div class="col form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="{{$datos['nombre']}}">
            </div>
            <div class="col form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="{{$datos['apellidos']}}">
            </div>
        </div>
        <div class="row">
            <div class="col form-group">
                <label for="dorsal">Dorsal</label>
                <input type="number" class="form-control" name="dorsal" placeholder="Dorsal" value="{{$datos['dorsal']}}">
            </div>
            <div class="col form-group">
                <label for="posicion">Posición</label>
                <select name="posicion" id="posicion" class="form-control">
                    @foreach($posiciones as $posicion)
                        @if($posicion == $datos['posicion'])
                            <option selected>{{$posicion}}</option>
                        @else
                            <option>{{$posicion}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col form-group">
                <label for="codigoBarras">Código de Barras</label>
                <input type="string" class="form-control" name="codigoBarras" value="{{$datos['barcode']}}" placeholder="Código de barras" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary m-1 ml-3" type="submit" name="crear">Crear</button>
                <button class="btn btn-success m-1" type="submit" name="limpiar">Limpiar</button>
                <button class="btn btn-info m-1" type="submit" name="volver">Volver</button>
                <button class="btn btn-secondary m-1" type="submit" name="barcode"><i class="fa-solid fa-barcode mr-1"></i> Generar Barcode</button>
            </div>
        </div>
    </form>
</div>
@endsection