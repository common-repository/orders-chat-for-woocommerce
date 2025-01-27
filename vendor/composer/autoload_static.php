<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6a0fc733105ebf1c20b1e8cdd3f25d20
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'U2Code\\OrderMessenger\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'U2Code\\OrderMessenger\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6a0fc733105ebf1c20b1e8cdd3f25d20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6a0fc733105ebf1c20b1e8cdd3f25d20::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6a0fc733105ebf1c20b1e8cdd3f25d20::$classMap;

        }, null, ClassLoader::class);
    }
}
