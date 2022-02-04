<?php

declare(strict_types=1);

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Service\Listener\Factory\ApplicationListenerFactory;
use Application\View\Helper\Config\ApplicationConfigData;
use Application\View\Helper\Config\CompanyConfigData;
use Application\View\Helper\Config\ConfigData;
use Application\View\Helper\Config\DesignConfigData;
use Application\View\Helper\Config\Factory\ApplicationConfigDataFactory;
use Application\View\Helper\Config\Factory\CompanyConfigDataFactory;
use Application\View\Helper\Config\Factory\ConfigDataFactory;
use Application\View\Helper\Config\Factory\DesignConfigDataFactory;
use Application\View\Helper\Config\Factory\ProjectConfigDataFactory;
use Application\View\Helper\Config\ProjectConfigData;
use Application\View\Helper\Path\CssPath;
use Application\View\Helper\Path\Factory\CssPathFactory;
use Application\View\Helper\Path\Factory\ImagePathFactory;
use Application\View\Helper\Path\Factory\JsPathFactory;
use Application\View\Helper\Path\Factory\SkinsCssPathFactory;
use Application\View\Helper\Path\Factory\SkinsJsPathFactory;
use Application\View\Helper\Path\Factory\SkinsPathFactory;
use Application\View\Helper\Path\Factory\VendorPathFactory;
use Application\View\Helper\Path\ImagePath;
use Application\View\Helper\Path\JsPath;
use Application\View\Helper\Path\SkinsCssPath;
use Application\View\Helper\Path\SkinsJsPath;
use Application\View\Helper\Path\SkinsPath;
use Application\View\Helper\Path\VendorPath;
use Laminas\Router\Http\Literal;
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
                return Poseidon ::getCore() -> getDbManager();
            },
            'log' => function () {
                return Poseidon ::getCore() -> getLogManager();
            },
            'design' => function () {
                return Poseidon ::getCore() -> getDesignManager();
            },
            'applicationListener' => ApplicationListenerFactory::class
        ]
    ],
    'router' => [
        'routes' => [
            'application' => [
                'type' => Literal::class,
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
    'view_helpers' => [
        'factories' => [
            JsPath::class => JsPathFactory::class,
            CssPath::class => CssPathFactory::class,
            VendorPath::class => VendorPathFactory::class,
            ImagePath::class => ImagePathFactory::class,
            ConfigData::class => ConfigDataFactory::class,
            SkinsPath::class => SkinsPathFactory::class,
            SkinsJsPath::class => SkinsJsPathFactory::class,
            SkinsCssPath::class => SkinsCssPathFactory::class,
            DesignConfigData::class => DesignConfigDataFactory::class,
            ApplicationConfigData::class => ApplicationConfigDataFactory::class,
            CompanyConfigData::class => CompanyConfigDataFactory::class,
            ProjectConfigData::class => ProjectConfigDataFactory::class
        ],
        'aliases' => [
            'jsPath' => JsPath::class,
            'cssPath' => CssPath::class,
            'vendorPath' => VendorPath::class,
            'imagePath' => ImagePath::class,
            'skinsPath' => SkinsPath::class,
            'skinsJsPath' => SkinsJsPath::class,
            'skinsCssPath' => SkinsCssPath::class,
            'config' => ConfigData::class,
            'designConfig' => DesignConfigData::class,
            'applicationConfig' => ApplicationConfigData::class,
            'companyConfig' => CompanyConfigData::class,
            'projectConfig' => ProjectConfigData::class
        ]
    ],
];
