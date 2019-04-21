<?php

/**
 * Class FormElement
 * Base Component of the Composite Pattern
 */
abstract class FormElement
{
    private $name, $title, $data;

    /**
     * FormElement constructor.
     * @param $name
     * @param $title
     */
    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @return string
     */
    abstract public function render();
}