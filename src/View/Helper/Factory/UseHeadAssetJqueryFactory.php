<?php

namespace Application\View\Helper\Factory;

use Application\View\Helper\UseHeadAssetJquery;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UseHeadAssetJqueryFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new UseHeadAssetJquery($container);
    }
}