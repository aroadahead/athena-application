<?php

namespace Application\View\Helper\Config\Factory;

use Application\View\Helper\Config\ProjectRouteConfigData;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class ProjectRouteConfigDataFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ProjectRouteConfigData($container);
    }
}