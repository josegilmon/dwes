<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit75e7b91723e605db88f942a180e6eb94
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'eftec\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'eftec\\' => 
        array (
            0 => __DIR__ . '/..' . '/eftec',
            1 => __DIR__ . '/..' . '/eftec/bladeone/vendor/eftec',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/modelo',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit75e7b91723e605db88f942a180e6eb94::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit75e7b91723e605db88f942a180e6eb94::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit75e7b91723e605db88f942a180e6eb94::$classMap;

        }, null, ClassLoader::class);
    }
}
