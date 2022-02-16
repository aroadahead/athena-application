<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;

class HtmlDir extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke(): string
    {
        $locale = $this -> container -> get('router') -> getLastMatchedLocaleKey();
        $key = "language.meta.{$locale}.dir";
        return $this -> container -> get('conf') -> facade()
            -> getI18nConfig($key);
    }
}