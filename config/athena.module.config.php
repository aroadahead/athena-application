<?php

return [
    'version' => '0.0.1',
    'author' => 'jrk',
    'listeners' => [
        ['service' => 'applicationListener', 'enabled' => true, 'priority' => 5000],
        ['service' => 'localeRouteInjector', 'enabled' => false, 'priority' => 30],
        ['service' => 'errorHandlerListener','enabled'=>true,'priority'=>1000]
    ],
    'commands' => []
];