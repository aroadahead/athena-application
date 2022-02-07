<?php

return [
    'version' => '0.0.1',
    'author' => 'jrk',
    'listeners' => [
        ['service' => 'applicationListener', 'enabled' => true, 'priority' => 5000],
        ['service' => 'localeRouteInjector', 'enabled' => true, 'priority' => 30]
    ],
    'commands' => []
];