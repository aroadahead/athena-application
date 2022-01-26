<?php

namespace Application\Service\Listener\Factory;

use Application\Service\Listener\ApplicationListener;
use Interop\Container\ContainerInterface;

class ApplicationListenerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ApplicationListener($container);
    }
}