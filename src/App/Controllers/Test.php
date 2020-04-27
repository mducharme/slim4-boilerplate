<?php

declare(strict_types=1);

namespace App\Controllers;

// From 'psr/http-message' (PSR-7)
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// From 'psr/container' (PSR-11)
use Psr\Container\ContainerInterface;

/**
 *  Controller
 */
class Test
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->container->get('view/renderer')->render(
            $response,
            'home',
            [
                'title' => 'Home from controller'
            ]
        );
    }
}