<?php

namespace Application\Service\Factory;

use Application\Service\ApplicationService;
use Interop\Container\ContainerInterface;

class ApplicationServiceFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ApplicationService($container);
    }
}