<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="tarea2.css">

</head>

<body>

    <div class="mensaje">
        <?php

            $limpiar = isset($_GET["limpiar"]) && $_GET["limpiar"] == 1;

            if ($limpiar) {
                $agenda = [];
            } else {

                if (isset($_POST["agenda"])) {
                    $agenda = $_POST["agenda"];
                } else {
                    $agenda = [];
                }

                $nombre = $_POST['nombre'];
                $telefono = $_POST['telefono'];
                if (isset($_POST["crear"]) && empty($nombre)) {
                    echo "El nombre es obligatorio!!";
                } else {
                    if (empty($telefono)) {
                        unset($agenda[$nombre]);
                    } else {
                        $agenda[$nombre] = $telefono;
                    }
                }
            }
        ?>
    </div>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <legend>Datos Agenda</legend>
            <div>
                <ul>
                    <?php
                        if (count($agenda) == 0) {
                            echo "<li>No hay contactos en la agenda</li>";
                        } else {
                            foreach($agenda as $nombre => $telefono) {
                                print "<input type='hidden' name='agenda[$nombre]' value='$telefono' />";
                                print "<li>$nombre: $telefono</li>";
                            }
                        }
                    ?>
                </ul>
            </div>
        </fieldset>

        <fieldset>
            <legend>Nuevo Contacto</legend>
            <input type="hidden" name="crear" value="1" />
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" />
            </div>
            <div>
                <label>Teléfono:</label>
                <input type="number" name="telefono" max="99999999" />
            </div>
            <input type="submit" value="Añadir Contacto" />
            <input type="button" value="Limpiar Campos" />
        </fieldset>
    </form>

    <fieldset>
        <legend>Vaciar Agenda</legend>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <input type="hidden" name="limpiar" value="1" />
            <input type="submit" value="Vaciar" />
        </form>
    </fieldset>

</body>

</html>