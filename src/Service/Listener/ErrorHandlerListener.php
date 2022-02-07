<?php

namespace Application\Service\Listener;

use Application\Session\Container\ExceptionContainer;
use AthenaCore\Mvc\Controller\MvcController;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\Response;
use Laminas\Stdlib\ResponseInterface;

class ErrorHandlerListener extends \AthenaCore\Mvc\Service\Listener\AbstractServiceListener
{

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this -> attachAs($events, MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], $priority);
    }

    public function onDispatchError(MvcEvent $e): ResponseInterface
    {
        $router = $e -> getRouter();
        $localeKey = $router -> getLastMatchedLocaleKey();
        $base = $router -> getBaseUrl();
        $response = new \Laminas\Http\Response();
        if (empty($e -> getRouteMatch())) {
            $response -> getHeaders() -> addHeaderLine('Location', "{$base}/{$localeKey}/not-found");
            $response -> setStatusCode(MvcController::NOT_FOUND);
        } else {
            $session = new ExceptionContainer();
            $session -> setMessage($e -> getResult());
            $session -> setReason($e -> getError());
            $session -> setController($e -> getController());
            $session -> setControllerClass($e -> getControllerClass());
            $session -> setException($e -> getParam('exception', false));
            $response -> setStatusCode(MvcController::SERVER_ERROR);
            $response -> getHeaders() -> addHeaderLine('Location', "{$base}/{$localeKey}/error");
        }
        $response -> sendHeaders();
        return $response;
    }
}