<?php

declare(strict_types=1);

namespace Application\View\Helper\Config\Factory;

use Application\View\Helper\Config\CompanyConfigData;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CompanyConfigDataFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new CompanyConfigData($container);
    }
}