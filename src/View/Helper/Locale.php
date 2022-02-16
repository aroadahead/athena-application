<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;

class Locale extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke()
    {
        return $this;
    }

    public function short():string
    {
        return $this->container->get('router')->getLastMatchedLocaleKey();
    }

    public function long():string
    {
        return $this->container->get('router')->getLastMatchedLocale();
    }
}