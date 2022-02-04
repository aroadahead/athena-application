<?php

declare(strict_types=1);

namespace Application\View\Helper\Path;

use Laminas\View\Helper\BasePath;
use Laminas\View\Renderer\RendererInterface;

class JsPath extends BasePath
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
    protected ?string $jsPath = null;

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
        if (is_null($this -> jsPath)) {
            $this -> jsPath = $this -> view -> designConfig('path.base_js_path');
        }
        return parent ::__invoke("{$this->jsPath}/$file");
    }
}