<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;

class App extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke(): self
    {
        return $this;
    }

    public function module(): string
    {
        return $this -> container -> get('registry') -> fetch('app.route.module');
    }

    public function controller(): string
    {
        return $this -> container -> get('registry') -> fetch('app.route.controller');
    }

    public function action(): string
    {
        return $this -> container -> get('registry') -> fetch('app.route.action');
    }

    public function route(): string
    {
        return $this -> container -> get('registry') -> fetch('app.route.matchedName');
    }

    public function protocol(): string
    {
        return $this -> container -> get('registry') -> fetch('app.server.server.protocol');
    }

    public function scheme():string
    {
        return ((int)$this -> container -> get('registry') -> fetch('app.server.server.port') === 443
            ? 'https' : 'http');
    }
}