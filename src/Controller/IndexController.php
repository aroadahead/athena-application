<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Session\Container\ExceptionContainer;
use AthenaBridge\Laminas\View\Model\ViewModel;

/**
 * Basic index controller
 */
class IndexController extends ApplicationModuleController
{
    /**
     * Not found action
     * @return ViewModel the view model
     */
    public function notFoundAction(): ViewModel
    {
        return $this->newViewModel();
    }

    public function errorAction(): ViewModel
    {
        $session = new ExceptionContainer();
        return $this->newViewModel([
            'reason' => $session -> getReason(),
            'exception' => $session -> getException(),
            'message' => $session -> getMessage(),
            'controller' => $session -> getController(),
            'controller_class' => $session -> getControllerClass(),
            'display_exceptions' => $this -> container -> get('env') -> isDevelopmentEnvironment()
        ]);
    }
}
