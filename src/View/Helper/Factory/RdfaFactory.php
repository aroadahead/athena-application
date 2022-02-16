<?php

namespace Application\View\Helper\Factory;

use Application\View\Helper\Rdfa;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RdfaFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new Rdfa($container);
    }
}