<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Session\Container\ExceptionContainer;
use Laminas\View\Model\ViewModel;

/**
 * Basic index controller
 */
class IndexController extends ApplicationController
{
    /**
     * Handles the application index action
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel([]);
    }

    public function aliveAction(): ViewModel
    {
        return new ViewModel(['hello' => $this -> applicationService() -> hello()]);
    }

    /**
     * Not found action
     * @return ViewModel the view model
     */
    public function notFoundAction(): ViewModel
    {
        return new ViewModel([]);
    }

    public function errorAction(): ViewModel
    {
        $session = new ExceptionContainer();
        $message = $session -> getMessage();
        $reason = $session -> getReason();
        $exception = $session -> getException();
        $controller = $session -> getController();
        $controllerClass = $session -> getControllerClass();
        $displayExceptions = $this -> container -> get('env') -> isDevelopmentEnvironment();
        return new ViewModel([
            'reason' => $reason,
            'exception' => $exception,
            'message' => $message,
            'controller' => $controller,
            'controller_class' => $controllerClass,
            'display_exceptions' => $displayExceptions
        ]);
    }
}
