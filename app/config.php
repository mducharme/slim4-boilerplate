<?php

declare(strict_types=1);

use Charcoal\Config\ConfigInterface;

/**
 * Bootstrap App Configuration
 */
return function (ConfigInterface $config) {
    // Required configuration key
    $config['basePath'] = dirname(__DIR__) . '/';

    $config->addfile(__DIR__ . '/../config/config.json');
    $config->addfile(__DIR__ . '/../config/config.local.json');

    $config->addfile(__DIR__ . '/../config/admin.json');
    $config->addfile(__DIR__ . '/../config/middlewares.json');
    $config->addfile(__DIR__ . '/../config/redirections.json');
    $config->addfile(__DIR__ . '/../config/routes.json');
};