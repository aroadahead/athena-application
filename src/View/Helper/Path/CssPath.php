<?php

namespace Application\View\Helper\Path;

use Laminas\View\Helper\BasePath;
use Laminas\View\Renderer\RendererInterface;
use function is_null;

class CssPath extends BasePath
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
    protected ?string $cssPath = null;

    /**
     * @param $renderer
     * @param $basePath
     */
    public function __construct($renderer, $basePath)
    {
        $this -> renderer = $renderer;
        $this -> setBasePath($basePath);
    }

    /**
     * @param null $file
     * @return string
     */
    public function __invoke($file = null): string
    {
        if (is_null($this -> cssPath)) {
            $this -> cssPath = $this -> view -> designConfig('path.base_css_path');
        }
        return parent ::__invoke("{$this->cssPath}/$file");
    }
}