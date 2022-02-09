<?php

namespace Application\Service\Listener;

use Application\Controller\ModuleController;
use Application\Session\Container\ExceptionContainer;
use AthenaCore\Mvc\Controller\AbstractMvcController;
use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ResponseInterface;

class ErrorHandlerListener extends AbstractServiceListener
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
        $force = ['force_canonical' => $forceCanonicalRedirect];
        if (empty($e -> getRouteMatch())) {
            $serverUrl = $renderer -> url('not-found', [], $force);
            $response -> getHeaders() -> addHeaderLine('Location', $serverUrl);
            $response -> setStatusCode(AbstractMvcController::NOT_FOUND);
            $response -> sendHeaders();
        } else {
            $session = new ExceptionContainer();
            $session -> setMessage($e -> getResult());
            $session -> setReason($e -> getError());
            $session -> setController($e -> getController());
            $session -> setControllerClass($e -> getControllerClass());
            $session -> setException($e -> getParam('exception', false));
            $serverUrl = $renderer -> url('error', [], $force);
            $response -> getHeaders() -> addHeaderLine('Location', $serverUrl);
            $response -> setStatusCode(AbstractMvcController::SERVER_ERROR);
            $response -> sendHeaders();
            return $response;
        }
    }
}