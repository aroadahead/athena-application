<?php

namespace Application\Mvc\Router\Http;

use AthenaCore\Mvc\Application\Config\Manager\ConfigManager;
use Laminas\Config\Config;
use Laminas\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;
use Laminas\Router\Http\RouteMatch;
use Laminas\Router\RoutePluginManager;
use Laminas\Stdlib\RequestInterface;
use Poseidon\Poseidon;

class LanguageTreeRouteStack extends TranslatorAwareTreeRouteStack
{
    protected string $lastMatchedLocale;
    protected string $lastMatchedLocaleKey;
    protected ConfigManager $configManager;
    protected ?Config $defaultConfig = null;
    protected bool $isMatched = false;

    public function __construct(RoutePluginManager $routePluginManager = null)
    {
        $this -> configManager = Poseidon ::getCore() -> getConfigManager();
        parent ::__construct($routePluginManager);
    }

    /**
     * @return string
     */
    public function getLastMatchedLocale(): string
    {
        return $this -> lastMatchedLocale;
    }

    /**
     * @param string $lastMatchedLocale
     * @return LanguageTreeRouteStack
     */
    public function setLastMatchedLocale(string $lastMatchedLocale): LanguageTreeRouteStack
    {
        $this -> lastMatchedLocale = $lastMatchedLocale;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastMatchedLocaleKey(): string
    {
        return $this -> lastMatchedLocaleKey;
    }

    /**
     * @param string $lastMatchedLocaleKey
     * @return LanguageTreeRouteStack
     */
    public function setLastMatchedLocaleKey(string $lastMatchedLocaleKey): LanguageTreeRouteStack
    {
        $this -> lastMatchedLocaleKey = $lastMatchedLocaleKey;
        return $this;
    }

    public function getLanguagePoolArray(): array
    {
        $langArray = $this -> lookup('language.available', true);
        if ($this -> lookup('language.use_full_locale_code_in_router')) {
            $keys = array_values($langArray);
            if ($this -> lookup('language.use_slashes_in_full_locale_code_in_router')) {
                $keys = array_map(function ($n) {
                    return str_ireplace('_', '-', $n);
                }, $keys);
            }
            if ($this -> lookup('language.use_lowercase_in_full_locale_code_in_router')) {
                $keys = array_map(function ($n) {
                    return strtolower($n);
                }, $keys);
            }
            return array_combine($keys, array_values($langArray));
        }
        return $langArray;
    }

    public function assemble(array $params = [], array $options = [])
    {
        $translator = null;
        if (isset($options['translator'])) {
            $translator = $options['translator'];
        } elseif ($this -> hasTranslator() && $this -> isTranslatorEnabled()) {
            $translator = $this -> getTranslator();
        }
        $languages = $this -> getLanguagePoolArray();
        $oldBase = $this -> baseUrl;
        if (count($languages) > 1) {
            if (isset($params['locale'])) {
                $locale = $params['locale'];
                $key = array_search($locale, $languages);
            } elseif (is_callable(array($translator, 'getLocale'))) {
                $locale = $translator -> getLocale();
                $key = array_search($locale, $languages);
            }
        }
        if (!empty($key)) {
            $this -> setBaseUrl($oldBase . '/' . $key);
            $this -> setLastMatchedLocaleKey($key);
        } else {
            $this -> setDefaultData();
        }
        $res = parent ::assemble($params, $options);
        $this -> setBaseUrl($oldBase);
        return $res;
    }

    public function match(RequestInterface $request, $pathOffset = null, array $options = []): mixed
    {
        if ($this -> isMatched) {
            return true;
        }
        $this -> isMatched = true;
        if (!method_exists($request, 'getUri')) {
            return null;
        }
        if (is_null($this -> baseUrl) && method_exists($request, 'getBaseUrl')) {
            $this -> setBaseUrl($request -> getBaseUrl());
        }
        $translator = null;
        if (isset($options['translator'])) {
            $translator = $options['translator'];
        } elseif ($this -> hasTranslator() && $this -> isTranslatorEnabled()) {
            $translator = $this -> getTranslator();
        }
        $languages = $this -> getLanguagePoolArray();
        $languageKeys = array_keys($languages);
        $oldBase = $this -> baseUrl;
        $locale = null;
        $uri = $request -> getUri();
        $baseUrlLen = strlen($this -> baseUrl);
        $path = ltrim(substr($uri -> getPath(), $baseUrlLen), '/');
        $pathParts = explode('/', $path);
        $localeKey = $pathParts[0];
        if (count($languages) > 1 && in_array($localeKey, $languageKeys)) {
            $locale = $languages[$localeKey];
            $this -> setBaseUrl($oldBase . '/' . $localeKey);
            $this -> setLastMatchedLocaleKey($localeKey);
        }
        if (empty($locale) && !empty($translator) && is_callable(array($translator, 'getLocale'))) {
            $locale = $translator -> getLocale();
            $this -> setDefaultData($locale);
        }

        $defaultLocale = Poseidon ::getCore() -> getEnvironmentManager() -> getDefaultLocale();
        if (is_null($locale)) {
            $locale = $defaultLocale;
        }
        $this -> setLastMatchedLocale($locale);

        $log = Poseidon ::getCore() -> getLogManager();

        $translator -> setLocale($locale);
        $translator -> setFallbackLocale($defaultLocale);
        \Locale ::setDefault($locale);
        $log -> info("Translator set: $locale with fallback $defaultLocale");

        $log -> info("Locale set: $locale with Key: $localeKey");
        $res = parent ::match($request, $pathOffset, $options);
        $this -> setBaseUrl($oldBase);
        if ($res instanceof RouteMatch && !empty($locale)) {
            $res -> setParam('locale', $locale);
            $res -> setParam('locale_key', $localeKey);
            Poseidon ::getCore() -> getUserManager() -> setUserLocale($locale);
        }
        return $res;
    }

    private function setDefaultData(string $locale): void
    {
        if ($this -> lookup('language.use_full_locale_code_in_router')) {
            $val = $locale;
            if ($this -> lookup('language.use_lowercase_in_full_locale_code_in_router')) {
                $val = strtolower($val);
            }
            if ($this -> lookup('language.use_slashes_in_full_locale_code_in_router')) {
                $val = str_ireplace('_', '-', $val);
            }
            $this -> setLastMatchedLocaleKey($val);
        } else {
            $this -> setLastMatchedLocaleKey($locale);
        }
    }

    private function lookup(string $node, bool $asArray = false): mixed
    {
        if ($asArray) {
            return $this -> configManager -> facade() -> getI18nConfig($node) -> toArray();
        }
        return $this -> configManager -> facade() -> getI18nConfig($node);
    }
}