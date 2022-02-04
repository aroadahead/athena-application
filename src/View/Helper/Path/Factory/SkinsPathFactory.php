<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\SkinsPath;
use Psr\Container\ContainerInterface;

class SkinsPathFactory extends AbstractPathFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SkinsPath
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new SkinsPath($renderer, $basePath);
    }
}