<?php

namespace Application\View\Helper;

class XmlDeclaration extends AbstractViewHelper
{
    public function __invoke()
    {
        $encoding = $this -> view -> applicationConfig('encoding');
        $designConfig = $this -> view -> designConfig('meta.xml_doctype_header');
        $attrs = array(
            'version' => $designConfig -> get('version'),
            'encoding' => $encoding,
            'standalone' => $designConfig -> get('standalone', null)
        );
        $attrString = '';
        foreach ($attrs as $key => $value) {
            if ($value !== null) {
                $attrString .= sprintf('%s="%s" ', $key, $value);
            }
        }
        return "<?xml $attrString?>";
    }
}