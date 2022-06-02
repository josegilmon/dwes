@extends('app')
@section('encabezado', "Mapa de Ruta")
@section('contenido')
<div class="container mt-3 ">
    <div class="d-flex justify-content-center">
        <div id='miMapa' data-points="{{ $points }}" data-routePath="{{ $routePath }}" style='width: 650px; height: 420px;'></div>
        <div class="mt-r">
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <a href='index.php' class='btn btn-warning'>Volver</a>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://www.bing.com/api/maps/mapcontrol?callback=loadMapRoute&key={{ $_ENV['MAP_API_KEY'] }}" async defer></script>
<script src="js/mapa.js"></script>
@endsection