@extends('app')
@section('titulo', "Jugadores")
@section('encabezado', "Listado de Jugadores")
@section('contenido')

@if(!empty($mensaje))
<div class="p-2 bg-success bg-opacity-50">
    {{$mensaje}}
</div>
@endif
<div class="mt-4 mb-1">
    <a href="crearJugador.php" class="btn btn-success"><i class="fa-solid fa-plus mr-1"></i> Nuevo Jugador</a>
</div>
<table class="table table-dark">
    <thead>
        <tr class="text-center">
            <th scope="col">Nombre Completo</th>
            <th scope="col">Posición</th>
            <th scope="col">Dorsal</th>
            <th scope="col">Código de Barras</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jugadores as $jugador)
        <tr class="text-center">
            <td>{{$jugador->getNombreCompleto()}}</td>
            <td>{{$jugador->getPosicion()}}</td>
            <td>{{$jugador->getDorsal() ?: "Sin asignar"}}</td>
            <td>{!! $barcode->getBarcodeSVG($jugador->getBarcode(), 'EAN13', 3, 33, 'white') !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection