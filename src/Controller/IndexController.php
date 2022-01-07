<?php

declare(strict_types=1);

namespace Application\Controller;

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
        return new ViewModel(['hello'=>$this->applicationService()->hello()]);
    }
}
