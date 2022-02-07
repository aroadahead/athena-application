<?php

namespace Application\Service\Listener\Factory;

use Application\Service\Listener\ErrorHandlerListener;
use Interop\Container\ContainerInterface;

class ErrorHandlerListenerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ErrorHandlerListener($container);
    }
}