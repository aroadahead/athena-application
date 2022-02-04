<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\ImagePath;
use Psr\Container\ContainerInterface;

class ImagePathFactory extends AbstractPathFactory
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new ImagePath($renderer, $basePath);
    }
}