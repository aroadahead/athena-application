<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;

class HtmlId extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke(string $tag):string
    {
        return 'test';
    }
}