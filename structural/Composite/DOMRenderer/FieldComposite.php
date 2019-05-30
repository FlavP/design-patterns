<?php
require_once('FormElement.php');

/**
 * Class FieldComposite
 * implements the infrastructure used by concrete implementations
 * to manage child objects
 */
abstract class FieldComposite extends FormElement
{
    /**
     * @var FormElement[]
     */
    protected $fields = [];

    /**
     * Adds a Child to the node
     * @param FormElement $field
     * @return void
     */
    public function add(FormElement $field){
        $name = $field->getName();
        $this->fields[$name] = $field;
    }

    /**
     * Removes a Child from the node
     * @param FormElement $component
     */
    public function remove(FormElement $component){
        $this->fields = array_filter($this->fields, function ($child) use ($component) {
            return $child != $component;
        });
    }

    /**
     * The composite takes the structured data
     * and distributes it to it's children
     * @param array $data
     */
    public function setData($data)
    {
        foreach ($this->fields as $name => $field){
            if(isset($data[$name]))
                $field->setData($data[$name]);
        }
    }

    /**
     * Go through the structure and return the composite data
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->fields as $name => $field){
            $data[$name] = $field->getData();
        }

        return $data;
    }

    /**
     * Actually a Composite's method is composed by
     * it's elements methods of the same name
     * @return string
     */
    public function render()
    {
        $output = '';
        foreach ($this->fields as $name => $field) {
            $output .= $field->render();
        }

        return $output;
    }
}