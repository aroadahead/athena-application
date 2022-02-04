<?php

declare(strict_types=1);

namespace Application\View\Helper\Config;

use Application\View\Helper\AbstractViewHelper;
use AthenaCore\Mvc\Application\Config\Manager\ConfigManager;
use Psr\Container\ContainerInterface;

class ConfigData extends AbstractViewHelper
{
    /**
     * Config manager static instance
     *
     * @var ConfigManager|null
     */
    protected static ?ConfigManager $configManager = null;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function __invoke(string $node=null,bool $asArray=false):mixed
    {
        if(self::$configManager===null){
            self::$configManager = $this->container->get('conf');
        }
        return self::$configManager->lookup($node,$asArray);
    }
}