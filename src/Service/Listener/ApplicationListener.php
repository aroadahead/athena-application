<?php

namespace Application\Service\Listener;

use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

class ApplicationListener extends AbstractServiceListener
{
    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this -> attachAs($events, MvcEvent::EVENT_DISPATCH, [$this, 'onRoute'], $priority);
    }

    public function onRoute(MvcEvent $e):void
    {
        $this->markTriggered();

        if($e->getRequest()->isXmlHttpRequest()){
            $e->getResult()->setTerminal(true);
        }
    }
}