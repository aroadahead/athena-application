<?php

namespace Application\Service\Listener;

use Application\Session\Container\ExceptionContainer;
use AthenaCore\Mvc\Controller\MvcController;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
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
        $response = $e -> getResponse();
        $renderer = $this -> container -> get('ViewHelperManager') -> getRenderer();
        $forceCanonicalRedirect = $this -> container -> get('conf')
            -> lookup('application.force_canonical_on_error_redirect');
        $force = [];
        if ($forceCanonicalRedirect) {
            $force = ['force_canonical' => true];
        }
        if (empty($e -> getRouteMatch())) {
            $serverUrl = $renderer -> url('not-found', [], $force);
            $response -> getHeaders() -> addHeaderLine('Location', $serverUrl);
            $response -> setStatusCode(MvcController::NOT_FOUND);
        } else {
            $session = new ExceptionContainer();
            $session -> setMessage($e -> getResult());
            $session -> setReason($e -> getError());
            $session -> setController($e -> getController());
            $session -> setControllerClass($e -> getControllerClass());
            $session -> setException($e -> getParam('exception', false));
            $serverUrl = $renderer -> url('error', [], $force);
            $response -> getHeaders() -> addHeaderLine('Location', $serverUrl);
            $response -> setStatusCode(MvcController::SERVER_ERROR);
        }
        $response -> sendHeaders();
    }
}