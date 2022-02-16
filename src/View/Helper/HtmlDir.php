<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;
use function array_search;

class HtmlDir extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke(): string
    {
        $locale = $this -> container -> get('router') -> getLastMatchedLocale();
        $available = $this -> container -> get('conf') -> facade()
            -> getI18nConfig('language.available');
        $code = array_search($locale, $available);
        $key = "language.meta.{$code}.dir";
        return $this -> container -> get('conf') -> facade()
            -> getI18nConfig($key);
    }
}