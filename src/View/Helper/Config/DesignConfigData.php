<?php

namespace Application\View\Helper\Config;

class DesignConfigData extends ConfigData
{
    public function __invoke(string $node = null, bool $asArray = false): mixed
    {
        $node = 'design' . (!is_null($node) ? ".{$node}" : "");
        return parent ::__invoke($node, $asArray);
    }
}