<?php

namespace Application\View\Helper\Factory;

use Application\View\Helper\HtmlId;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HtmlIdFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new HtmlId($container);
    }
}