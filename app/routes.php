<?php

declare(strict_types=1);

use App\Controllers\HomeCustom;
use Charcoal\App\RouteMapper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

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
        foreach ($redirections as $key => $redirectionOptions) {
            if (is_string($redirectionOptions)) {
                $redirectionOptions = ['target' => $redirectionOptions];
            }
            $redirectionOptions['type'] = 'redirection';
            $ret[$key] = $redirectionOptions;
        }
        return $ret;
    };

    $templatesParser = function (array $templates): array {
        $ret = [];
        foreach ($templates as $key => $templateOptions) {
            $templateOptions['type'] = 'template';
            $ret[$key] = $templateOptions;
        }
        return $ret;
    };

    $actionsParser = function (array $actions): array {
        $ret = [];
        foreach ($actions as $key => $actionOptions) {
            $actionOptions['type'] = 'action';
            $ret[$key] = $actionOptions;
        }
        return $ret;
    };

    $scriptsParser = function (array $scripts): array {
        $ret = [];
        foreach ($scripts as $key => $scriptOptions) {
            $scriptOptions['type'] = 'script';
            $ret[$key] = $scriptOptions;
        }
        return $ret;
    };

    $container = $app->getContainer();
    $config = $container->get('config');

    $routeMapper = new RouteMapper();
    //$scriptMapper = new RouteMapper();

    // Load routes from config
    if ($config->has('routes')) {
        $routes = $config->get('routes');

        $templates = $routes['templates'] ?? [];
        $actions = $routes['actions'] ?? [];
        //$scripts = $routes['scripts'] ?? [];

        $routeMapper($app, $templatesParser($templates));
        $routeMapper($app, $actionsParser($actions));
        //$scriptMapper($app, $scriptsParser($scripts));

        // Map all routes
        unset($routes['templates'], $routes['actions'], $routes['scripts']);
        $routeMapper($app, $routes);
    }
    // Load redirections from config
    if ($config->has('redirections')) {
        $routeMapper($app, $redirectionsParser($config->get('redirections')));
    }

    /**
     * Because the home route is a Slim Route Controller, it can be used as such
     * (See /home in routes.json for how to use the same class as a view route).
     */
    $app->get('/', HomeCustom::class);
    //$app->get('/json1', HomeCustom::class);
    //$app->get('/view-example', \Charcoal\Slim\Handlers\View::class);

    $catchall = function(Request $request, Response $response, array $args): Response {
        $path = $args['path'];
        throw new HttpNotFoundException($request, sprintf('Page not found "%s"', $path));
    };
    $app->get('/{path:.*}', $catchall);
};