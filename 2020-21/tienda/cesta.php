<?php
require_once('include/CestaCompra.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) 
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

// Recuperamos la cesta de la compra
$cesta = CestaCompra::carga_cesta();

function listaProductos($productos)
{
    $coste = 0;
    foreach ($productos as $p) {
        echo "<p><span class='codigo'>" . $p->getcodigo() . "</span>";
        echo "<span class='nombre'>" . $p->getnombre() . "</span>";
        echo "<span class='precio'>" . $p->getPVP() . "</span></p>";
        $coste += $p->getPVP();
    }        
    echo "<hr />";
    echo "<p><span class='pagar'>Precio total: " . $coste . " €</span></p>";
    echo "<form action='pagar.php' method='post'>";
    echo "<p><span class='pagar'>";
    echo "<input type='submit' name='pagar' value='Pagar'/>";
    echo "</span></p></form>";                 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Desarrollo Web en Entorno Servidor -->
<!-- Tema 7 : Aplicaciones web dinámicas: PHP y Javascript -->
<!-- Ejercicio: Formulario de Login con Xajax: cesta.php -->
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ejercicio Tema 7: Cesta de la Compra utilizando Xajax</title>
  <link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body class="pagcesta">

<div id="contenedor">
  <div id="encabezado">
    <h1>Cesta de la compra</h1>
  </div>
  <div id="productos">
<?php listaProductos($cesta->get_productos()); ?>
  </div>
  <br class="divisor" />
  <div id="pie">
    <form action='logoff.php' method='post'>
        <input type='submit' name='desconectar' value='Desconectar usuario <?php echo $_SESSION['usuario']; ?>'/>
    </form>        
  </div>
</div>
</body>
</html>
