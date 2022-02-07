<?php

namespace Application\Mvc\Router\Http\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class LanguageTreeRouteStackDelegatorFactory implements \Laminas\ServiceManager\Factory\DelegatorFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        return $callback();
    }
}