<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc8af9dde1b1d61de19be3fd03a064734
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Klein\\' => 6,
        ),
        'C' => 
        array (
            'Curl\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Klein\\' => 
        array (
            0 => __DIR__ . '/..' . '/klein/klein/src/Klein',
        ),
        'Curl\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc8af9dde1b1d61de19be3fd03a064734::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc8af9dde1b1d61de19be3fd03a064734::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}