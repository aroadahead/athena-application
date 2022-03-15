<?php
declare(strict_types=1);

namespace Application\Controller;

use AthenaBridge\Laminas\Authentication\AuthenticationService;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use AthenaBridge\Laminas\View\Model\FeedModel;
use AthenaBridge\Laminas\View\Model\JsonModel;
use AthenaBridge\Laminas\View\Model\ViewModel;
use AthenaCore\Mvc\Application\Application\Core\ApplicationCore;
use AthenaCore\Mvc\Application\Config\Facade\Facade;
use AthenaCore\Mvc\Application\Laminas\Manager\Exception\ExceptionManager;
use AthenaCore\Mvc\Controller\AbstractMvcController;
use AthenaSodium\Entity\User;
use http\Exception\InvalidArgumentException;
use Interop\Container\ContainerInterface;
use Laminas\Filter\Word\CamelCaseToDash;
use Laminas\Http\Response;
use Laminas\Uri\UriFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use function is_null;
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
     * Authentication Service
     *
     * @var AuthenticationService|null
     */
    private ?AuthenticationService $authenticationService;

    private ?ManagerInterface $sessionManager;

    private ?Facade $configFacade;

    private ?ExceptionManager $exceptionManager;

    private ?ApplicationCore $applicationCore;

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
        $this -> applicationCore = $this -> container -> get('core');
        $this -> exceptionManager = $this -> applicationCore -> getLaminasManager() -> getExceptionManager();
    }

    public function core(): ApplicationCore
    {
        return $this -> applicationCore;
    }

    public function throwException(string $class, string $msg, array $args = []): void
    {
        $this -> exceptionManager -> throwException($class, $msg, $args);
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

    /**
     * @param array $args
     * @return ViewModel
     */
    public function newViewModel(array $args = []): ViewModel
    {
        return new ViewModel($args);
    }

    /**
     * @param array $args
     * @return JsonModel
     */
    public function newJsonModel(array $args = []): JsonModel
    {
        return new JsonModel($args);
    }

    /**
     * @param array $args
     * @return FeedModel
     */
    public function newFeedModel(array $args = []): FeedModel
    {
        return new FeedModel($args);
    }

    /**
     * @return string
     */
    public function redirectUrl(): string
    {
        $redirectUrl = $this -> params() -> fromQuery('r', '');
        if (strlen($redirectUrl) > 2048) {
            $this -> throwException(InvalidArgumentException::class, 'Redirect url too long.');
        }
        return $redirectUrl;
    }

    /**
     * @return AuthenticationService
     */
    public function authService(): AuthenticationService
    {
        return new AuthenticationService();
    }

    /**
     * @return ManagerInterface
     */
    public function sessionManager(): ManagerInterface
    {
        if($this->sessionManager === null){
            $this->sessionManager = Container::getDefaultManager();
        }
        return $this -> sessionManager;
    }

    /**
     * @return Facade
     */
    public function configFacade(): Facade
    {
        if($this->configFacade === null){
            $this->configFacade = $this->applicationCore
                ->getConfigManager()->facade();
        }
        return $this -> configFacade;
    }

    /**
     * @param string $redirectUrl
     * @param bool $checkHost
     * @return Response
     */
    public function verifyAndRedirectUrl(string $redirectUrl, bool $checkHost = true): Response
    {
        $uri = UriFactory ::factory($redirectUrl);
        if (!$uri -> isValid()) {
            $this -> throwException(InvalidArgumentException::class, 'invalid redirect uri: %s', [$redirectUrl]);
        }
        if ($checkHost) {
            if (!is_null($uri -> getHost())) {
                $this -> throwException(InvalidArgumentException::class, 'invalid redirect uri: %s', [$redirectUrl]);
            }
        }
        return $this -> redirect() -> toUrl($redirectUrl);
    }

    /**
     * @return User|null
     */
    public function user(): User|null
    {
        return (($this -> authService() -> hasIdentity())
            ? $this -> authService() -> getIdentity() : null);
    }

    /**
     * @return Response
     */
    public function toLogin(): Response
    {
        return $this -> redirect() -> toRoute('login');
    }

    /**
     * @return Response
     */
    public function toNotFound(): Response
    {
        return $this -> redirect() -> toRoute('not-found');
    }

    /**
     * @return Response
     */
    public function toDashboard(): Response
    {
        return (($this -> authService() -> hasIdentity())
            ? $this -> redirect() -> toRoute('passport.dashboard') : $this -> notFound());
    }
}