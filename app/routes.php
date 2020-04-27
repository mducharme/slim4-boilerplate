<?php

declare(strict_types=1);

// From 'slim/slim'
use Slim\App;

// From 'locomotivemtl/charcoal-app'
use Charcoal\App\RouteMapper;

/**
 *
 */
return function (App $app) {
    /**
     * Parse a simple list of redirections. They can be either in the
     * `"pattern" => "target"` format or `"pattern" => [options]` format.
     *
     * @param array $redirections
     * @return array
     */
    $redirectionsParser = function (array $redirections): array {
        $ret = [];
        foreach ($redirections as $key => $options) {
            if (is_string($options)) {
                $options = ['target' => $options];
            }
            $options['type'] = 'redirection';

            $ret[$key] = $options;
        }
        return $ret;
    };

    $container = $app->getContainer();
    $config = $container->get('config');

    $autoRoutes = new RouteMapper();

    // Load routes from config
    if (!empty($config['routes'])) {
        $autoRoutes($app, $config['routes']);
    }
    // Load redirections from config
    if (!empty($config['redirections'])) {
        $autoRoutes($app, $redirectionsParser($config['redirections']));
    }

    /**
     * Because the home route is a Slime Route Controller, it can be used as such
     * (See /home in routes.json for how to use the same class as a view route).
     */
    $app->get('/', \App\Controllers\Test::class);
};