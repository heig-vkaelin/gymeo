<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit00051b5f1f9667e2557362bd129a1d01
{
    public static $files = array (
        '5ec26a44593cffc3089bdca7ce7a56c3' => __DIR__ . '/../..' . '/core/helpers.php',
    );

    public static $classMap = array (
        'App\\Controllers\\ExercicesController' => __DIR__ . '/../..' . '/app/controllers/ExercicesController.php',
        'App\\Controllers\\NicknamesController' => __DIR__ . '/../..' . '/app/controllers/NicknamesController.php',
        'App\\Controllers\\ProgramsController' => __DIR__ . '/../..' . '/app/controllers/ProgramsController.php',
        'App\\Controllers\\SeriesController' => __DIR__ . '/../..' . '/app/controllers/SeriesController.php',
        'App\\Controllers\\SessionsController' => __DIR__ . '/../..' . '/app/controllers/SessionsController.php',
        'App\\Controllers\\TeachersController' => __DIR__ . '/../..' . '/app/controllers/TeachersController.php',
        'App\\Controllers\\UsersController' => __DIR__ . '/../..' . '/app/controllers/UsersController.php',
        'App\\Core\\App' => __DIR__ . '/../..' . '/core/App.php',
        'App\\Core\\Database\\Database' => __DIR__ . '/../..' . '/core/database/Database.php',
        'App\\Core\\Request' => __DIR__ . '/../..' . '/core/Request.php',
        'App\\Core\\Router' => __DIR__ . '/../..' . '/core/Router.php',
        'App\\Repositories\\ExercicesRepository' => __DIR__ . '/../..' . '/app/repositories/ExercicesRepository.php',
        'App\\Repositories\\ProgramsRepository' => __DIR__ . '/../..' . '/app/repositories/ProgramsRepository.php',
        'App\\Repositories\\Repository' => __DIR__ . '/../..' . '/app/repositories/Repository.php',
        'App\\Repositories\\SeriesRepository' => __DIR__ . '/../..' . '/app/repositories/SeriesRepository.php',
        'App\\Repositories\\SessionsRepository' => __DIR__ . '/../..' . '/app/repositories/SessionsRepository.php',
        'App\\Repositories\\UsersRepository' => __DIR__ . '/../..' . '/app/repositories/UsersRepository.php',
        'ComposerAutoloaderInit00051b5f1f9667e2557362bd129a1d01' => __DIR__ . '/..' . '/composer/autoload_real.php',
        'Composer\\Autoload\\ClassLoader' => __DIR__ . '/..' . '/composer/ClassLoader.php',
        'Composer\\Autoload\\ComposerStaticInit00051b5f1f9667e2557362bd129a1d01' => __DIR__ . '/..' . '/composer/autoload_static.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit00051b5f1f9667e2557362bd129a1d01::$classMap;

        }, null, ClassLoader::class);
    }
}
