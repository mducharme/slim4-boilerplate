<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Foo
{
    public function __construct(ContainerInterface $container)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            json_encode(
                array_merge(
                    $request->getAttribute('options'),
                    [
                        'foo' => 'from context. ' . rand(0, 100)
                    ]
                )
            )
        );
        return $response;
    }
}