<?php

namespace Application\Service\Listener;

use Application\Mvc\Router\Http\LanguageTreeRouteStack;
use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use Laminas\EventManager\EventManagerInterface;
use Laminas\I18n\Translator\TranslatorInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\RequestInterface;
use Psr\Container\ContainerInterface;

class LocaleRouteInjectorListener extends AbstractServiceListener
{

    protected LanguageTreeRouteStack $router;
    protected RequestInterface $request;
    protected TranslatorInterface $translator;
    protected $listeners = [];

    public function __construct(protected ContainerInterface $container)
    {
        $this -> router = $this -> container -> get('router');
        $this -> request = $this -> container -> get('request');
        $this -> translator = $this -> container -> get('MvcTranslator') -> getTranslator();
        parent ::__construct($this -> container);
    }

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this -> attachAs($events, MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], $priority);
    }

    public function onRoute(MvcEvent $e): void
    {
        $this -> markTriggered();

        $this -> router -> match($this -> request);
        $locale = $this -> router -> getLastMatchedLocale();
        if (empty($locale)) {
            return;
        }
        $this -> translator -> setLocale($locale);
        $this -> translator -> setFallbackLocale($this -> container -> get('conf')
            -> lookup('i18n.language.default.locale'));
        \Locale::setDefault($locale);
        $this->container->get('log')->info("Translator set with locale: $locale");
    }
}