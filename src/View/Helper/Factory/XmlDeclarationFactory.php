<?php

declare(strict_types=1);

namespace Application\View\Helper\Factory;

use Application\View\Helper\XmlDeclaration;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class XmlDeclarationFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new XmlDeclaration();
    }
}