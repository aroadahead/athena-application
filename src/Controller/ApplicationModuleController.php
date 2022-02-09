<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ApplicationService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Application module controller
 */
class ApplicationModuleController extends ModuleController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function applicationService(): ApplicationService
    {
        return $this -> invokeService();
    }
}
