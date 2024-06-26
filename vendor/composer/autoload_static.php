<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit02837a12241e56c08b9cf57688c5e08f
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EasyRdf\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EasyRdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/easyrdf/easyrdf/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit02837a12241e56c08b9cf57688c5e08f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit02837a12241e56c08b9cf57688c5e08f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit02837a12241e56c08b9cf57688c5e08f::$classMap;

        }, null, ClassLoader::class);
    }
}
