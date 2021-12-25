<?php

declare(strict_types=1);

namespace Application\Controller;

use Bridge\Laminas\View\Model\ViewModel;

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
        return new ViewModel();
    }
}
