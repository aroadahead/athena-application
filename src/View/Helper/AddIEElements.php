<?php
declare(strict_types=1);

namespace Application\View\Helper;

class AddIEElements extends AbstractViewHelper
{
    public function __invoke(): string
    {
        $elements = $this -> view -> designConfig('meta.ie_elements') -> toArray();
        $elementsStr = implode(' ', $elements);
        return "<!--[if lt IE 9]>
    	<script>'" . $elementsStr . "'.replace(/\w+/g,function(n){document.createElement(n)});</script>
	   <![endif]-->";
    }
}