<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Slim\App;
use Slim\Psr7\Response as SlimResponse;

/**
 * Attach PSR-15-style function middlewares on the Slim App.
 *
 * To attach only on certain routes or groups, do so manually in the routes definitions.
 *
 * Note that sub-modules may also attach their own middlewares to the App.
 */
return function (App $app) {

    // Example: Add new middleware via anonymous class
    $app->add(new class() implements Middleware {
        function process(Request $request, RequestHandler $handler) : Response
        {
            return $handler->handle($request);
        }
    });

};