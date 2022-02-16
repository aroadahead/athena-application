<?php
declare(strict_types=1);

namespace Application\Service\Listener;

use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use IDS\Init;
use IDS\Monitor;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use function array_walk;

class ApplicationListener extends AbstractServiceListener
{
    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this -> attachAs($events, MvcEvent::EVENT_DISPATCH, [$this, 'onRoute'], $priority);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function onRoute(MvcEvent $e): void
    {
        $this -> markTriggered();

        if ($e -> getRequest() -> isXmlHttpRequest()) {
            $e -> getResult() -> setTerminal(true);
        }

        if ($this -> container -> get('conf')
            -> facade() -> getSecurityConfig('xss.phpids_scan_enabled')) {
            $this -> scanXss($e);
        }
    }

    private function scanXss(MvcEvent $e): void
    {
        $request = array(
            'REQUEST' => $_REQUEST,
            'GET' => $e -> getRequest() -> getQuery(),
            'POST' => $e -> getRequest() -> getPost(),
            'COOKIE' => $e -> getRequest() -> getCookie()
        );

        $configFile = $this -> container -> get('path') -> facade() -> assets('phpids/Config.ini.php');
        $facade = $this -> container -> get('conf') -> facade();
        $init = Init ::init($configFile);
        $overrides = $facade -> getSecurityConfig('xss.phpids_config') -> toArray();
        foreach ($overrides as $key => $data) {
            array_walk($data,
                fn($e, $k) => $init -> setConfig(array($key => array($k => $e)), true));
        }
        $ids = new Monitor($init);
        $result = $ids -> run($request);
        if (!$result -> isEmpty()) {
            $impact = $facade -> getSecurityConfig('xss.phpids_min_impact_level');
            if ($result -> getImpact() >= $impact) {
                die("XSS Attack Detected.");
            }
        }
    }
}