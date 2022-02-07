<?php

namespace Application\View\Helper;

class LanguageDropDown extends AbstractViewHelper
{
    public function __construct(protected ContainerInterface $container)
    {

    }

    public function __invoke()
    {
        $langDropDownLabel = $this -> view -> designConfig('layout.extra.languages_dropdown_label');
        $xhtml = "<li class='nav-item dropdown'><a href='#' id='link_language' role='button' aria-haspopup='true' 
        aria-expanded='false' class='nav-link dropdown-toggle nav-label' data-toggle='dropdown'>" .
            $this -> getView() -> translate($langDropDownLabel) . "<span class='caret'></span></a>";
        $xhtml .= "<div class='dropdown-menu' aria-labelledby='link_language'>";
        $xhtml .= $this -> getNavBarContent();
        $xhtml .= "</div>";
        $xhtml .= "</li>";
        return $xhtml;
    }

    private function getUrl($locale): string
    {
        $route = $this -> container -> get('registry') -> fetch("app.route.matchedName");
        $currParams = $this -> container -> get('registry') -> fetch("app.route.params");
        $currParams['locale'] = $locale;
        return $this -> getView() -> url($route, $currParams, [], true);
    }

    private function getNavBarContent(): string
    {
        $xhtml = "";
        $languages = $this -> container -> get('conf') -> lookup('application.language.available', true);
        $languageMeta = $this -> container -> get('conf') -> lookup('application.language.meta', true);
        foreach ($languages as $lang => $locale) {
            $meta = $languageMeta[$lang];
            $languageDisplay = $meta['language'];
            $currUrl = $this -> getUrl($locale);
            $xhtml .= "<a class='dropdown-item' href='$currUrl'>" . $this -> getView() -> translate($languageDisplay) . "</a>";
        }
        return $xhtml;
    }
}