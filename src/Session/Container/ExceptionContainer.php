<?php

namespace Application\Session\Container;

use Laminas\Session\Container;
use Laminas\View\Model\ViewModel;
use Throwable;

class ExceptionContainer extends Container
{
    /**
     * Namespace Name
     *
     * @var string
     */
    private const NAMESPACE_NAME = 'errorHandler';

    /**
     * Reason Var
     *
     * @var string
     */
    private const VAR_REASON = 'reason';

    /**
     * Message Var
     *
     * @var string
     */
    private const VAR_MESSAGE = 'message';

    /**
     * Exception Var
     *
     * @var string
     */
    private const VAR_EXCEPTION = 'exception';

    /**
     * Controller Var
     *
     * @var string
     */
    private const VAR_CONTROLLER = 'controller';

    /**
     * Controller Class Var
     *
     * @var string
     */
    private const VAR_CONTROLLER_CLASS = 'controller_class';

    /**
     *
     */
    public function __construct()
    {
        parent ::__construct(self::NAMESPACE_NAME);
    }

    /**
     * Clears container session storage
     *
     * @return void
     */
    public function clearStorage(): void
    {
        $this -> getStorage() -> clear();
    }

    /**
     * Set Reason
     *
     * @param string $reason the exception reason
     * @return void
     */
    public function setReason(string $reason): void
    {
        $this -> offsetSet(self::VAR_REASON, $reason);
    }

    /**
     * Set Message
     *
     * @param string|ViewModel $message the exception message
     * @return void
     */
    public function setMessage(string|ViewModel $message): void
    {
        $this -> offsetSet(self::VAR_MESSAGE, $message);
    }

    /**
     * Set Exception
     *
     * @param Throwable $exception the exception instance
     */
    public function setException(Throwable $exception): void
    {
        $this -> offsetSet(self::VAR_EXCEPTION, $exception);
    }

    /**
     * Set Controller
     *
     * @param string $controller the exception controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this -> offsetSet(self::VAR_CONTROLLER, $controller);
    }

    /**
     * Set Controller Class
     *
     * @param string $controllerClass the exception controller class
     * @return void
     */
    public function setControllerClass(string $controllerClass): void
    {
        $this -> offsetSet(self::VAR_CONTROLLER_CLASS, $controllerClass);
    }

    /**
     * Return reason
     *
     * @return string the exception reason
     */
    public function getReason(): string
    {
        return $this -> offsetGet(self::VAR_REASON);
    }

    /**
     * Return message
     *
     * @return string the canonical message
     */
    public function getMessage(): string
    {
        $message = $this -> offsetGet(self::VAR_MESSAGE);
        if ($message instanceof ViewModel) {
            $message = $message -> getVariable(self::VAR_MESSAGE);
        }
        return $message;
    }

    /**
     * Return controller
     *
     * @return string the controller
     */
    public function getController(): string
    {
        return $this -> offsetGet(self::VAR_CONTROLLER);
    }

    /**
     * Return controller class
     *
     * @return string the controller class
     */
    public function getControllerClass(): string
    {
        return $this -> offsetGet(self::VAR_CONTROLLER_CLASS);
    }

    /**
     * Return exception
     *
     * @return Throwable the exception instance
     */
    public function getException(): Throwable
    {
        return $this -> offsetGet(self::VAR_EXCEPTION);
    }
}