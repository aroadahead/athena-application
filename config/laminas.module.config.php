<?php

declare(strict_types=1);

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\IndexController;
use Application\Mvc\Router\Http\Factory\LanguageTreeRouteStackDelegatorFactory;
use Application\Mvc\Router\Http\LanguageTreeRouteStack;
use Application\Service\Listener\Factory\ApplicationListenerFactory;
use Application\Service\Listener\Factory\LocaleRouteInjectorListenerFactory;
use Application\View\Helper\AddIEElements;
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
use Application\View\Helper\Factory\AddIEElementsFactory;
use Application\View\Helper\Factory\XmlDeclarationFactory;
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
use Application\View\Helper\XmlDeclaration;
use Laminas\I18n\Translator\Loader\Ini;
use Laminas\Router\Http\Literal;
use Poseidon\Poseidon;


$core = Poseidon ::getCore();
$defaultLocale = $core -> getConfigManager()
    -> facade() -> getI18nConfig('language.default.locale');

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
            'core' => function () use ($core) {
                return $core;
            },
            'conf' => function () use ($core) {
                return $core -> getConfigManager();
            },
            'fs' => function () use ($core) {
                return $core -> getFilesystemManager();
            },
            'dp' => function () use ($core) {
                return $core -> getFilesystemManager() -> getDirectoryPaths() -> facade();
            },
            'db' => function () use ($core) {
                return $core -> getDbManager();
            },
            'log' => function () use ($core) {
                return $core -> getLogManager();
            },
            'design' => function () use ($core) {
                return $core -> getDesignManager();
            },
            'applicationListener' => ApplicationListenerFactory::class,
            'localeRouteInjector' => LocaleRouteInjectorListenerFactory::class
        ],
        'delegators' => [
            'HttpRouter' => [LanguageTreeRouteStackDelegatorFactory::class],
            'Laminas\Router\Http\TreeRouteStack' => [LanguageTreeRouteStackDelegatorFactory::class]
        ],
        'services' => [],
        'invokables' => [],
        'abstract_factories' => [],
        'aliases' => [],
        'initializers' => [],
        'lazy_services' => [],
        'shared' => [],
        'shared_by_default' => []
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
        'router_class' => LanguageTreeRouteStack::class,
        'default_params' => [
            'locale' => $defaultLocale
        ],
        'translator_text_domain' => 'routing'
    ],
    'translator' => [
        'locale' => $defaultLocale,
        'translation_file_patterns' => array(
            array(
                'type' => Ini::class,
                'base_dir' => $core -> getFilesystemManager()
                    -> getDirectoryPaths() -> facade() -> language(),
                'pattern' => '%s.ini'
            )
        )
    ],
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
            ProjectConfigData::class => ProjectConfigDataFactory::class,
            AddIEElements::class => AddIEElementsFactory::class,
            XmlDeclaration::class => XmlDeclarationFactory::class
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
            'projectConfig' => ProjectConfigData::class,
            'addIeElements' => AddIEElements::class,
            'xmlDeclaration' => XmlDeclaration::class
        ]
    ],
];
