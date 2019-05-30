<?php
require_once('FormElement.php');

/**
 * Class Input
 * Leave Element of the Composite Pattern
 * Can't have children
 */
class Input extends FormElement
{
    private $type;

    /**
     * Input constructor.
     * @param $name
     * @param $title
     * @param $type
     */
    public function __construct($name, $title, $type)
    {
        parent::__construct($name, $title);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return string
     * Does the actual work
     */
    public function render()
    {
        return "<label for=\"{$this->getName()}\">{$this->getTitle()}</label>\n" .
            "<input name=\"{$this->getName()}\" type=\"{$this->getType()}\" value=\"{$this->getData()}\">\n";
    }
}