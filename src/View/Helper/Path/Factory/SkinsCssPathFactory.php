<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\SkinsJsPath;
use Psr\Container\ContainerInterface;

class SkinsCssPathFactory extends AbstractPathFactory
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new SkinsJsPath($renderer, $basePath);
    }
}