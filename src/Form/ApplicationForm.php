<?php

declare(strict_types=1);

namespace Application\Form;

use AthenaBridge\Laminas\Form\Element\Button;
use AthenaBridge\Laminas\Form\Element\ButtonSubmit;
use AthenaBridge\Laminas\Form\Element\Captcha;
use AthenaBridge\Laminas\Form\Element\Checkbox;
use AthenaBridge\Laminas\Form\Element\Csrf;
use AthenaBridge\Laminas\Form\Element\Email;
use AthenaBridge\Laminas\Form\Element\File;
use AthenaBridge\Laminas\Form\Element\Hidden;
use AthenaBridge\Laminas\Form\Element\Password;
use AthenaBridge\Laminas\Form\Element\Select;
use AthenaBridge\Laminas\Form\Element\Submit;
use AthenaBridge\Laminas\Form\Element\Text;
use AthenaCore\Mvc\Form\AbstractForm;
use Laminas\Config\Config;
use Laminas\Form\Element;
use Laminas\Form\FormInterface;

class ApplicationForm extends AbstractForm
{
    public function getConfig(string $node, bool $asArray = false): Config|array|string|null
    {
        return $this -> container() -> get('conf') -> lookup($node, $asArray);
    }

    /**
     * Return values as array
     * @return array
     */
    public function getFilteredDataAsArray(): array
    {
        return $this -> getData(FormInterface::VALUES_AS_ARRAY);
    }

    /**
     * Set the action url
     *
     * @param string $actionUrl action url to set
     * @return void
     */
    public function setAction(string $actionUrl): void
    {
        $this -> setAttribute('action', $actionUrl);
    }

    /**
     * post method
     *
     * @return void
     */
    public function postMethod(): void
    {
        $this -> setAttribute('method', parent::METHOD_POST);
    }

    /**
     * delete method
     *
     * @return void
     */
    public function deleteMethod(): void
    {
        $this -> setAttribute('method', parent::METHOD_DELETE);
    }

    /**
     * get method
     *
     * @return void
     */
    public function GETMethod(): void
    {
        $this -> setAttribute('method', parent::METHOD_GET);
    }

    /**
     * head method
     *
     * @return void
     */
    public function headMethod(): void
    {
        $this -> setAttribute('method', parent::METHOD_HEAD);
    }

    /**
     * put method
     *
     * @return void
     */
    public function putMethod(): void
    {
        $this -> setAttribute('method', parent::METHOD_PUT);
    }

    /**
     * add captcha element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function captchaElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Captcha::class, $options, $attributes);
    }

    /**
     * add email element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function emailElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Email::class, $options, $attributes);
    }

    /**
     * add text element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function textElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Text::class, $options, $attributes);
    }

    /**
     * add password element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function passwordElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Password::class, $options, $attributes);
    }

    /**
     * add checkbox element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function checkboxElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Checkbox::class, $options, $attributes);
    }

    /**
     * add button submit element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function buttonSubmitElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, ButtonSubmit::class, $options, $attributes);
    }

    /**
     * add button element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function buttonElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Button::class, $options, $attributes);
    }

    /**
     * add hidden element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function hiddenElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Hidden::class, $options, $attributes);
    }

    /**
     * add csrf element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function csrfElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Csrf::class, $options, $attributes);
    }

    /**
     * add submit element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function submitElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Submit::class, $options, $attributes);
    }

    /**
     * add select element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function selectElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, Select::class, $options, $attributes);
    }

    /**
     * add file element
     *
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    public function fileElement(string $name, array $options = [], array $attributes = []): Element
    {
        return $this -> _addElement($name, File::class, $options, $attributes);
    }

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @param array $attributes
     * @return Element
     */
    private function _addElement(string $name, string $type, array $options = [], array $attributes = []): Element
    {
        return $this -> add([
            'type' => $type,
            'name' => $name,
            'options' => $options,
            'attributes' => $attributes
        ]);
    }
}