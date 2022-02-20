@extends('app')
@section('titulo', "Productos")
@section('encabezado', "Listado de Productos")
@section('contenido')
<table class="table table-striped">
    <thead>
        <tr class="text-center">
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
            <th scope="col">Nombre Corto</th>
            <th scope="col">Precio</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr class="text-center">
            <th scope="row">{{$producto->getId()}}</th>
            <td>{{$producto->getNombre()}}</td>
            <td>{{$producto->getNombreCorto()}}</td>
            @if($producto->getPvp()>100)
            <td class='text-danger'>{{$producto->getPvp()}}</td>
            @else
            <td class='text-success'>{{$producto->getPvp()}}</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<div class="container mt-5 text-center">
    <a href="login.php" class="btn btn-info">Volver</a>
</div>
@endsection