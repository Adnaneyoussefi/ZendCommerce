<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit225a3c451f3345703770042b652a91ba
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit225a3c451f3345703770042b652a91ba::$classMap;

        }, null, ClassLoader::class);
    }
}