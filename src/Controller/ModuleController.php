<?php
declare(strict_types=1);

namespace Application\Controller;

use AthenaCore\Mvc\Controller\AbstractMvcController;
use AthenaSodium\Entity\User;
use http\Exception\InvalidArgumentException;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Filter\Word\CamelCaseToDash;
use Laminas\View\Model\FeedModel;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use function strlen;
use function strpos;
use function strtolower;
use function substr;

class ModuleController extends AbstractMvcController
{
    /**
     * Root namespace
     */
    protected string $rootNamespace;

    /**
     * Camelcase to dash filter
     */
    protected static ?CamelCaseToDash $filter = null;

    /** @throws ReflectionException */
    public function __construct(protected ContainerInterface $container)
    {
        if (self ::$filter === null) {
            self ::$filter = new CamelCaseToDash();
        }

        $namespace = (new ReflectionClass($this)) -> getNamespaceName();
        $namespace = substr($namespace, 0, strpos($namespace, '\\'));
        $this -> rootNamespace = strtolower(self ::$filter -> filter($namespace));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function invokeService(?string $module = null): mixed
    {
        if ($module === null) {
            $module = $this -> rootNamespace;
        }

        return $this -> container -> get('modules') -> moduleLoader() -> load($module);
    }

    /**
     * @return JsonModel
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function aliveAction(): JsonModel
    {
        return new JsonModel([
            'hello' => $this -> invokeService() -> hello(),
            'module' => $this -> rootNamespace
        ]);
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel([]);
    }

    public function newViewModel(array $args = []): ViewModel
    {
        return new ViewModel($args);
    }

    public function newJsonModel(array $args = []): JsonModel
    {
        return new JsonModel($args);
    }

    public function newFeedModel(array $args = []): FeedModel
    {
        return new FeedModel($args);
    }

    public function redirectUrl(): string
    {
        $redirectUrl = $this -> params() -> fromQuery('r', '');
        if (strlen($redirectUrl) > 2048) {
            throw new InvalidArgumentException("Redirect url too long.");
        }
        return $redirectUrl;
    }

    public function user(): User|null
    {
        $authService = new AuthenticationService();
        if (!$authService -> hasIdentity()) {
            return null;
        }
        return $authService -> getIdentity();
    }
}