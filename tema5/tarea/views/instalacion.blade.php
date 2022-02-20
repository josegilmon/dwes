@extends('app')
@section('titulo', "Instalación")
@section('encabezado', "Instalación")
@section('contenido')
<div class="container text-center">
    <form action="crearDatos.php" method="POST">
        <button class="btn btn-success" type="submit" name="instalar"><i class="fa-solid fa-database"></i> Instalar Datos de Ejemplo</button>
    </form>
</div>
@endsection