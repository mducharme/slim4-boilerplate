<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new \Charcoal\App\Bootstrap(new \Charcoal\App\AppConfig());
$bootstrap->addConfig((require __DIR__ . '/../app/config.php'));
$bootstrap->addContainer((require __DIR__ . '/../app/services.php'));
$bootstrap->addBootstrap((require __DIR__ . '/../app/modules.php'));
$bootstrap->addApp((require __DIR__ . '/../app/middlewares.php'));
$bootstrap->addApp((require __DIR__ . '/../app/routes.php'));
$app = $bootstrap();
$app->run();
