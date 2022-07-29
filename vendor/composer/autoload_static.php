<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc27b7a8f58bbbb514638993b7ac1284d
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vion\\TestCase\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vion\\TestCase\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitc27b7a8f58bbbb514638993b7ac1284d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc27b7a8f58bbbb514638993b7ac1284d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc27b7a8f58bbbb514638993b7ac1284d::$classMap;

        }, null, ClassLoader::class);
    }
}
