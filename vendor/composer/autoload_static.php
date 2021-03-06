<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4d3784c37d3cfe9be1904453f2058cf2
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FigoliQuinn\\BetterCustomPostTypes\\' => 34,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FigoliQuinn\\BetterCustomPostTypes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4d3784c37d3cfe9be1904453f2058cf2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4d3784c37d3cfe9be1904453f2058cf2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
