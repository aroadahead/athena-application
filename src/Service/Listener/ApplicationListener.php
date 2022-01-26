<?php

namespace Application\Service\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Psr\Container\ContainerInterface;

class ApplicationListener extends AbstractListenerAggregate
{
    public function __construct(protected ContainerInterface $container)
    {
    }
    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        // TODO: Implement attach() method.
    }
}