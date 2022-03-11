<?php


 function autoload_9bcc1a870f3e247296ea845a78858d7a($class)
{
    $classes = array(
        'App\Calculator' => __DIR__ .'/Calculator.php',
        'App\Add' => __DIR__ .'/Add.php',
        'App\AddResponse' => __DIR__ .'/AddResponse.php',
        'App\Subtract' => __DIR__ .'/Subtract.php',
        'App\SubtractResponse' => __DIR__ .'/SubtractResponse.php',
        'App\Multiply' => __DIR__ .'/Multiply.php',
        'App\MultiplyResponse' => __DIR__ .'/MultiplyResponse.php',
        'App\Divide' => __DIR__ .'/Divide.php',
        'App\DivideResponse' => __DIR__ .'/DivideResponse.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_9bcc1a870f3e247296ea845a78858d7a');

// Do nothing. The rest is just leftovers from the code generation.
{
}
