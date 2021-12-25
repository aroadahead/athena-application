<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ApplicationService;
use AthenaCore\Mvc\Controller\MvcController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Application module controller
 */
class ApplicationController extends MvcController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function applicationService(): ApplicationService
    {
        return $this->invokeService();
    }
}
