<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5d1915b4c025a1f2b452ae12adb5ab3e
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

        spl_autoload_register(array('ComposerAutoloaderInit5d1915b4c025a1f2b452ae12adb5ab3e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit5d1915b4c025a1f2b452ae12adb5ab3e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit5d1915b4c025a1f2b452ae12adb5ab3e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}