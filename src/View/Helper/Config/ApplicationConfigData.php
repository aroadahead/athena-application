<?php

namespace Application\View\Helper\Config;

use function is_null;

class ApplicationConfigData extends ConfigData
{
    public function __invoke(string $node = null, bool $asArray = false): mixed
    {
        $node = 'application' . (!is_null($node) ? ".{$node}" : "");
        return parent ::__invoke($node, $asArray);
    }
}