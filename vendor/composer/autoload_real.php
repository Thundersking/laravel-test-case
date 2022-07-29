<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc27b7a8f58bbbb514638993b7ac1284d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitc27b7a8f58bbbb514638993b7ac1284d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc27b7a8f58bbbb514638993b7ac1284d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc27b7a8f58bbbb514638993b7ac1284d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
