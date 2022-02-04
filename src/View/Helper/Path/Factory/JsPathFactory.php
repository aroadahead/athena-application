<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\JsPath;
use Psr\Container\ContainerInterface;

class JsPathFactory extends AbstractPathFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new JsPath($renderer, $basePath);
    }
}