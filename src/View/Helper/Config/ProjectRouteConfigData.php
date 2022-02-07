<?php

namespace Application\View\Helper\Config;

use function is_null;

class ProjectRouteConfigData extends ProjectConfigData
{
    public function __invoke(string $node = null, bool $asArray = false): mixed
    {
        $config = parent ::__invoke('route', $asArray);
        if($asArray){
            return $config[$node];
        }
        return $config->$node;
    }
}