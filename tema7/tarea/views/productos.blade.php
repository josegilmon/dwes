@extends('app')
@section('titulo', "Productos")
@section('encabezado', "Listado de Productos")
@section('contenido')
<table class="table table-dark table-striped">
    <thead>
        <tr class="text-center">
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
            <th scope="col">Valoración</th>
            <th scope="col">Valorar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr class="text-center">
            <th scope="row">{{$producto->getId()}}</th>
            <td>{{$producto->getNombre()}}</td>
            <!--td>Sin valorar</td-->
            <td>
                <div id="rating-{{$producto->getId()}}">
                    <script type="text/javascript">
                        document.write(pintarEstrellas('{{$producto->getVotos()}}', '{{$producto->getValoracion()}}'));
                    </script>
                </div>
            </td>
            <td class="row">
                <div class="col-6">
                    <select id="valorar-{{$producto->getId()}}" class="form-select" aria-label="Default select example">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary" onclick="votar('{{$producto->getId()}}', '{{$producto->getVotos()}}')">Votar</button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="container mt-5 text-center">
    <a href="login.php" class="btn btn-info">Volver</a>
</div>
@endsection