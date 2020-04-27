<?php

declare(strict_types=1);

namespace App\Contexts;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Json
{
    public function __construct(ContainerInterface $container)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): array
    {
        return array_merge($request->getAttribute('options'), [
            'json' => 'from context'
        ]);
    }
}