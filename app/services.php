<?php

declare(strict_types=1);

// From 'pimple/pimple'
use Pimple\Container;

use Charcoal\App\Services\AppHandlersProvider;
use Charcoal\App\Services\AppControllersProvider;

/**
 * Services to register on the Bootstrap's Pimple Container.
 */
return function (Container $container) {
    $container->register(new AppHandlersProvider());
    $container->extend(
        'app/handlers',
        function (array $handlers, Container $container): array {
            // Add Custom route handlers here
            return $handlers;
        }
    );

    $container->register(new AppControllersProvider());
    $container->extend(
        'app/controllers',
        function (array $controllers, Container $container): array {
            // Add custom route controllers here
            $controllers['home'] = \App\Controllers\Test::class;
            $controllers['example1'] = \App\Controllers\Test::class;
            return $controllers;
        }
    );
    $container->extend(
        'app/contexts',
        function (array $contexts, Container $container): array {
            // Add custom contexts (for views and json) here
            $contexts['views/home'] = \App\Contexts\Views\Home::class;
            $contexts['json1'] = \App\Contexts\Json::class;
            $contexts['json2'] = [
                'array' => 'is defined in container directly'
            ];
            $contexts['json3'] = function () use ($container) : \App\Contexts\Json {
                return new  \App\Contexts\Json($container['container/psr11']);
            };
            return $contexts;
        }
    );

    // Register PDO database(s) (automatically set up from config['databases'])
    // `database` is mapped automatically to `databases/default`
    $container->register(new \Charcoal\App\Services\DatabaseProvider());
    $container->extend(
        'databases',
        function (array $databases, Container $container): array {
            return $databases;
        }
    );

    // Register league/flysystem filesystems (automatically set up from config['filesystems'])`
    // `public` and `private` should always be registered by default.
    $container->register(new \Charcoal\App\Services\FilesystemProvider());
    $container->extend(
        'filesystems',
        function (array $filesystems, Container $container): array {
            // Add additional filesystems here.
            return $filesystems;
        }
    );

    // Register monolog PSR-3 `logger `(handlers automatically set up from config['logger'])
    $container->register(new \Charcoal\App\Services\LoggerProvider());

    // Register PSR6 Cache (setup automatically from config['cache']
    $container->register(new Charcoal\Cache\ServiceProvider\CacheServiceProvider());

    // Register translator (setup automatically from config)
    $container->register(new Charcoal\Translator\ServiceProvider\TranslatorServiceProvider());

    // Register view and renderer (setup automatically from config['view']
    $container->register(new \Charcoal\View\ViewServiceProvider());
//    $container->extend('views', function(array $views, Container $container) : array {
//        // Add more views here.
//        return $views;
//    });
    $container->extend(
        'view/mustache/helpers',
        function (array $helpers, Container $container): array {
            // Add mustache helpers here
            return $helpers;
        }
    );
};