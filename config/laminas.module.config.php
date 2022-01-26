<?php

declare(strict_types=1);

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Service\Listener\Factory\ApplicationListenerFactory;
use AthenaCore\Mvc\Service\Listener\CoreListener;
use AthenaCore\Mvc\Service\Listener\Factory\CoreListenerFactory;
use Poseidon\Poseidon;

return [
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            'core' => function () {
                return Poseidon ::getCore();
            },
            'conf' => function () {
                return Poseidon ::getCore() -> getConfigManager();
            },
            'fs' => function () {
                return Poseidon ::getCore() -> getFilesystemManager();
            },
            'dp' => function () {
                return Poseidon ::getCore() -> getFilesystemManager() -> getDirectoryPaths() -> facade();
            },
            'db' => function () {
                return Poseidon::getCore() -> getDbManager();
            },
            'applicationListener' => ApplicationListenerFactory::class
        ]
    ],
    'router' => [
        'routes' => [
            'application' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'translator' => [],
    'view_helpers' => [],
];
