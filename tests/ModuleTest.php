<?php

declare(strict_types=1);

namespace ApplicationTest;

use Application\Module;
use PHPUnit\Framework\TestCase;
use function array_walk;

class ModuleTest extends TestCase
{

    /**
     * Test config provider invoke
     */
    public function testInvoke(): void
    {
        $config = (new Module()) -> getConfig();

        $keys = ['view_manager', 'controllers', 'service_manager', 'router', 'translator', 'view_helpers','athena-core'];
        array_walk($keys, function ($item) use ($config) {
            self ::assertArrayHasKey($item, $config, "Expected config to have {$item} array key.");
        });
    }
}