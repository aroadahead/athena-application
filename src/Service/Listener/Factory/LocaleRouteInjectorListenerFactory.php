<?php

namespace Application\Service\Listener\Factory;

use Application\Service\Listener\LocaleRouteInjectorListener;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LocaleRouteInjectorListenerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LocaleRouteInjectorListener($this);
    }
}