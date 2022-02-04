<?php

namespace Application\View\Helper\Config\Factory;

use Application\View\Helper\Config\ConfigData;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ConfigDataFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ConfigData($container);
    }
}