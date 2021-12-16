<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0e5339f1d8c974379d71665253443e66
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0e5339f1d8c974379d71665253443e66::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0e5339f1d8c974379d71665253443e66::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
