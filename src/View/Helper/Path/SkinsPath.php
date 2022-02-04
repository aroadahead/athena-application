<?php
declare(strict_types=1);
namespace Application\View\Helper\Path;

use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Renderer\RendererInterface;

class SkinsPath extends AbstractHelper
{
    /**
     * Base path
     *
     * @var string
     */
    protected string $basePath;

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
    protected ?string $skinsPath = null;

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
     * @param array $args
     * @param string|null $file
     * @return string
     */
    public function __invoke(array $args, string $file = null): string
    {
        $skinPath = implode("/", $args);
        if (null !== $file) {
            $skinPath .= '/' . ltrim($file, '/');
        }

        if (is_null($this -> skinsPath)) {
            $this -> skinsPath = $this -> view -> designConfig('path.base_skins_path');
        }
        return $this -> basePath . "/{$this->skinsPath}/" . $skinPath;
    }

    /**
     * Set the base path.
     *
     * @param string $basePath
     * @return self
     */
    public function setBasePath($basePath)
    {
        $this -> basePath = rtrim($basePath, '/');
        return $this;
    }
}