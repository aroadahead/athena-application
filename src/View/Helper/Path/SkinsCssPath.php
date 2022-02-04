<?php

namespace Application\View\Helper\Path;

use Laminas\View\Renderer\RendererInterface;

class SkinsCssPath extends SkinsPath
{
    /**
     * Renderer interface
     *
     * @var RendererInterface
     */
    protected RendererInterface $renderer;

    /**
     * Path
     *
     * @var string|null
     */
    protected ?string $skinsCssPath = null;

    /**
     * @param $renderer
     * @param $basePath
     */
    public function __construct($renderer, $basePath)
    {
        parent ::__construct($renderer, $basePath);
    }

    /**
     * @param array $args
     * @param string|null $file
     * @return string
     */
    public function __invoke(array $args, string $file = null): string
    {
        if (is_null($this -> skinsCssPath)) {
            $this -> skinsCssPath = $this -> view -> designConfig('meta.base_skins_js_path');
        }
        $file = "{$this->skinsCssPath}/$file";
        return parent ::__invoke($args, $file); // TODO: Change the autogenerated stub
    }
}