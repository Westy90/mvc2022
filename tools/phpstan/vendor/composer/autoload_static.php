<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite904bae526402edc3ed3190f24459356
{
    public static $files = array (
        '9b38cf48e83f5d8f60375221cd213eee' => __DIR__ . '/..' . '/phpstan/phpstan/bootstrap.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite904bae526402edc3ed3190f24459356::$classMap;

        }, null, ClassLoader::class);
    }
}
