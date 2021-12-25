<?php

declare(strict_types=1);

use Laminas\Mvc\Application;

require_once __DIR__.'/../bootstrap.php';

$appConfig = require __DIR__ . '/../config/application.config.php';

Application::init($appConfig)->run();