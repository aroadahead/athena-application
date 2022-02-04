<?php

namespace Application\View\Helper\Config\Factory;

use Application\View\Helper\Config\DesignConfigData;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class DesignConfigDataFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new DesignConfigData($container);
    }
}