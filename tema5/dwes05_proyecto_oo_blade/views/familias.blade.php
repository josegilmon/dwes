@extends('app')
@section('titulo', "Familias")
@section('encabezado', "Listado de Familias")

@section('contenido')
<table class="table table-striped">
    <thead>
        <tr class="text-center">
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
        </tr>
    </thead>
    <tbody>
        @foreach($familias as $familia)
        <tr class="text-center">
            <th scope="row">{{$familia->getCod()}}</th>
            <td>{{$familia->getNombre()}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="container mt-5 text-center">
    <a href="login.php" class="btn btn-info">Volver</a>
</div>
@endsection