<?php

namespace Application\View\Helper\Path\Factory;

use Application\View\Helper\Path\VendorPath;
use Interop\Container\ContainerInterface;

class VendorPathFactory extends AbstractPathFactory
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $basePath = parent ::__invoke($container, $requestedName, $options);
        $renderer = $this -> getRenderer();
        return new VendorPath($renderer, $basePath);
    }
}