<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css para usar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        crossorigin="anonymous">

    <title>Calculadora SOAP</title>

    <style type="text/css">
        div.container-fluid {
            width: 250px;
        }

        .operations>div,
        .numbers>div {
            padding: 10px;
        }

        .btn {
            width: 100%;
        }

        .operations {
            color: white;
        }

        .numbers {
            color: black;
        }
    </style>
</head>

<body class="bg-warning text-white">

<?php

    require "./vendor/autoload.php";
    require "./src/autoload.php";

    use App\Add;
    use App\AddResponse;
    use App\Subtract;
    use App\SubtractResponse;
    use App\Multiply;
    use App\MultiplyResponse;
    use App\Divide;
    use App\DivideResponse;
    use App\Calculator;

    $operadores = ['+', '-', '*', '/'];
    $botones = [7, 8, 9, '=', 4, 5, 6, null, 1, 2, 3, null, 'AC', 0];

    $total = 0;

    if (isset($_POST["operacion"])) {
        $operacion = $_POST["operacion"];
    } else {
        $operacion = "";
    }

    if (isset($_POST["boton"])) {

        $accion = $_POST["boton"];

        if ($accion === "=") {

            $regex = '/(\d+)([\+\-\*\/]+)(\d+)/';
            preg_match($regex, $operacion, $matches);

            if (count($matches) < 4) {
                $error = "No hay suficientes operandos";
            } else {
                $calculator = new Calculator();
                switch ($matches[2]) {
                    case "+":
                        $suma = new Add(intval($matches[1]), intval($matches[3]));
                        $total = $calculator->Add($suma)->getAddResult();
                        break;
                    case "-":
                        $resta = new Subtract(intval($matches[1]), intval($matches[3]));
                        $total = $calculator->Subtract($resta)->getSubtractResult();
                        break;
                    case "*":
                        $producto = new Multiply(intval($matches[1]), intval($matches[3]));
                        $total = $calculator->Multiply($producto)->getMultiplyResult();
                        break;
                    case "/":
                        $division = new Divide(intval($matches[1]), intval($matches[3]));
                        $total = $calculator->Divide($division)->getDivideResult();
                        break;
                }
            }

            $operacion .= $accion;

        } else if ($accion === "AC") {
            $total = 0;
            $operacion = "";
        } else {
            $operacion .= $accion;
        }

    }

?>

    <div class="container-fluid bg-white mx-auto">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

            <div class="row result bg-dark">
                <input type="hidden" name="operacion" value="<?php echo $operacion ?>">
                <div class="col-12 text-end fs-6"><?php echo $operacion ?></div>
                <div class="col-12 text-end fs-1"><?php echo $total ?></div>
            </div>

            <div class="row operations">
                <?php
                    for ($i = 0; $i < count($operadores); $i++) {
                        echo "<div class='col-3'>";
                        echo "  <input type='submit' class='btn btn-info' name='boton' value='$operadores[$i]'>";
                        echo "</div>";
                    }
                ?>
            </div>

            <div class="row numbers">
                <?php
                    for ($i = 0; $i < count($botones); $i++) {

                        $boton = $botones[$i];
                        $class = $boton === "AC" ? "btn-danger" : "btn-light";

                        echo "<div class='col-3'>";
                        echo "  <input type='submit' class='btn $class' name='boton' value='$botones[$i]'>";
                        echo "</div>";
                    }
                ?>
            </div>

            <?php
                if (isset($error)) {
                    echo "<div class='bg-danger'>$error</div>";
                }
            ?>
        </form>

    </div>



</body>

</html>