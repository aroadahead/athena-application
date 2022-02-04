<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\CssPath;
use Psr\Container\ContainerInterface;

class CssPathFactory extends AbstractPathFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new CssPath($renderer, $basePath);
    }
}