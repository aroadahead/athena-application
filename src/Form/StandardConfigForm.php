<?php

namespace Application\Form;

use AthenaBridge\Laminas\Config\Config;
use AthenaException\Config\ConfigNodeNotFoundException;
use AthenaException\File\FileNotFoundException;
use AthenaException\Form\ConfigDataElementMissingException;
use function is_file;

class StandardConfigForm extends ApplicationForm
{
    public function __construct($name = null, array $options = [])
    {
        parent ::__construct($name, $options);
        $this -> assemble($name);
    }

    public function assemble(string $formId): void
    {
        $formConfigPath = $this -> resolveFormConfigPath($formId);
        $formConfigData = require_once $formConfigPath;
        $formConfig = new Config($formConfigData);
        foreach ($formConfig as $element => $data) {
            if (!$data -> has('enabled')) {
                $message = "%s is missing enabled form config option from form id %s.";
                throw new ConfigNodeNotFoundException(sprintf($message, $element, $formId));
            }
            if (!$data -> get('enabled')) continue;
            $this -> validateConfigData($data, $formId);
            $options = $data -> get('options') -> toArray();
            $attributes = $data -> get('attributes') -> toArray();
            $type = $data -> get('elementType');
            $method = "${type}Element";
            $this -> $method($element, $options, $attributes);
            $inputFilter = $this -> getInputFilter();
            $inputFilter -> add([
                'name' => $element,
                'required' => $data -> get('input_filter') -> get('required'),
                'filters' => $data -> get('input_filter') -> get('filters') -> toArray(),
                'validators' => $data -> get('input_filter') -> get('validators') -> toArray()
            ]);
        }
    }

    private function resolveFormConfigPath(string $formId): string
    {
        $file = $this -> container() -> get('path') -> facade() -> forms($formId . '.php');
        if (!is_file($file)) {
            throw new FileNotFoundException("{$file} does not exist.");
        }
        return $file;
    }

    /**
     * Validates form config data
     *
     * @param Config $data the form config data
     * @param string $formId the form config data id
     * @return void
     * @throws ConfigDataElementMissingException when a field is missing from the form config data
     */
    private function validateConfigData(Config $data, string $formId): void
    {
        $check = ['options', 'attributes', 'elementType', 'input_filter'];
        array_walk($check, function ($item) use ($data, $formId) {
            if (!$data -> offsetExists($item)) {
                $message = "%s missing from form config %s!";
                throw new ConfigNodeNotFoundException(sprintf($message, $item, $formId));
            }
        });
        $check = ['required', 'filters', 'validators'];
        $inputFilterConfig = $data -> get('input_filter');
        array_walk($check, function ($item) use ($inputFilterConfig, $formId) {
            if (!$inputFilterConfig -> offsetExists($item)) {
                $message = "%s missing from input filters form config %s!";
                throw new ConfigNodeNotFoundException(sprintf($message, $item, $formId));
            }
        });
    }
}