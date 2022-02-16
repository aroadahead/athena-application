<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;
use function array_keys;
use function array_map;
use function array_values;
use function implode;

class Rdfa extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke()
    {
        $rdfa = $this -> container -> get('conf') -> facade() -> getDesignConfig('html.rdfa')
            -> toArray();
        return implode('  ', array_map(fn($k, $v): string => "$k: $v",
            array_keys($rdfa), array_values($rdfa)));
    }
}