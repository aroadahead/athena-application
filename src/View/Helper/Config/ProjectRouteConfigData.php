<?php

namespace Application\View\Helper\Config;

use function is_null;

class ProjectRouteConfigData extends ProjectConfigData
{
    public function __invoke(string $node = null, bool $asArray = false): mixed
    {
        $node = 'route' . (!is_null($node) ? ".{$node}" : "");
        return parent ::__invoke($node, $asArray);
    }
}