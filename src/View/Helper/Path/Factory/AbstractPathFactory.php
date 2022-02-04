<?php

declare(strict_types=1);

namespace Application\View\Helper\Path\Factory;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\RendererInterface;
use function is_callable;

class AbstractPathFactory implements FactoryInterface
{
    protected static ?string $basePath = null;
    protected ContainerInterface $container;

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $this -> container = $container;
        if (self ::$basePath === null) {
            $basePath = null;
            $config = $container -> get('config');
            if (isset($config['view_manager']) && isset($config['view_manager']['base_path'])) {
                $basePath = $config['view_manager']['base_path'];
            } else {
                $config = $container -> get('conf') -> facade() -> getApplicationConfig('base_path');
                if ($config !== null) {
                    $basePath = $config;
                } else {
                    $request = $container -> get('Request');
                    if (is_callable([$request, 'getBasePath'])) {
                        $basePath = $request -> getBasePath();
                    }
                }
            }
            self ::$basePath = $basePath;
        }
        return self ::$basePath;
    }

    protected function getRenderer(): RendererInterface
    {
        return $this -> container -> get('ViewHelperManager') -> getRenderer();
    }
}