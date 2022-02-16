<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Session\Container\ExceptionContainer;
use Laminas\View\Model\ViewModel;

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
        return new ViewModel([]);
    }

    public function errorAction(): ViewModel
    {
        $session = new ExceptionContainer();
        return new ViewModel([
            'reason' => $session -> getReason(),
            'exception' => $session -> getException(),
            'message' => $session -> getMessage(),
            'controller' => $session -> getController(),
            'controller_class' => $session -> getControllerClass(),
            'display_exceptions' => $this -> container -> get('env') -> isDevelopmentEnvironment()
        ]);
    }
}
