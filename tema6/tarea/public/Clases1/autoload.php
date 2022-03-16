<?php


 function autoload_d1df0b69423b69666a9456d72cca5d5d($class)
{
    $classes = array(
        'Clases\TareaOperacionesService' => __DIR__ .'/TareaOperacionesService.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_d1df0b69423b69666a9456d72cca5d5d');

// Do nothing. The rest is just leftovers from the code generation.
{
}
