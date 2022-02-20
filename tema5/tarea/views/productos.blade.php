@extends('app')
@section('titulo', "Jugadores")
@section('encabezado', "Listado de Jugadores")
@section('contenido')
<div class="container mt-5 text-center">
    <a href="crearJugador.php" class="btn btn-info">Crear</a>
</div>
<table class="table table-striped">
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
            <th scope="row">{{$jugador->getNombre()}}</th>
            <td>{{$jugador->getPosicion()}}</td>
            @if(isset($jugador->getDorsal()))
            <td>{{$jugador->getDorsal()}}</td>
            @else
            <td>Sin asignar</td>
            @endif
            <td>{{$jugador->getCodigoBarras()}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection