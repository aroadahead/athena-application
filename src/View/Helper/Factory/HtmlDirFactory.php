<?php

declare(strict_types=1);

namespace Application\View\Helper\Factory;

use Application\View\Helper\HtmlDir;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HtmlDirFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new HtmlDir($container);
    }
}