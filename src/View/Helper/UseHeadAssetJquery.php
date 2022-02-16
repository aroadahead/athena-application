<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;

class UseHeadAssetJquery extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke():bool
    {
        return true;
    }
}