<?php

declare(strict_types=1);

use Charcoal\App\Services\AppServiceProvider;
use Pimple\Container;

/**
 * Services to register on the Bootstrap's Pimple Container.
 */
return function (Container $container) {

    // Register all default "Charcoal" app service providers (cache, logger, filesystem, database, etc.)
    $container->register(new AppServiceProvider());

    $container->extend(
        'app/handlers',
        function (array $handlers, Container $container): array {
            // Add Custom route handlers here
            return $handlers;
        }
    );
    $container->extend(
        'app/controllers',
        function (array $controllers, Container $container): array {
            // Add custom route controllers here
            $controllers['home'] = \App\Controllers\HomeCustom::class;
            $controllers['example1'] = \App\Controllers\HomeCustom::class;
            return $controllers;
        }
    );
    $container->extend(
        'app/contexts',
        function (array $contexts, Container $container): array {
            // Add custom json contexts here
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
    $container->extend(
        'app/views',
        function (array $views, Container $container): array {
            // Add custom view controllers here
            $views['home'] = \App\Views\Home::class;
            return $views;
        }
    );
    $container->extend(
        'databases',
        function (array $databases, Container $container): array {
            // Add additional databases configuration here.
            return $databases;
        }
    );
    $container->extend(
        'filesystems',
        function (array $filesystems, Container $container): array {
            // Add additional filesystems here.
            return $filesystems;
        }
    );
    $container->extend(
        'view/mustache/helpers',
        function (array $helpers, Container $container): array {
            // Add mustache helpers here
            return $helpers;
        }
    );
};