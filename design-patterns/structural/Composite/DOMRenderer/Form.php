<?php
require_once ('FieldComposite.php');

/**
 * Form is a concrete Composite
 * Class Form
 */
class Form extends FieldComposite
{
 protected $url;

    /**
     * Form constructor.
     * @param $name
     * @param $title
     * @param $url
     */

 public function __construct($name, $title, $url)
 {
     parent::__construct($name, $title);
     $this->url = $url;
 }

    /**
     * @return string
     */
 public function render()
 {
     $output = parent::render();
     return "<form action=\"{$this->url}\">\n<h3>{$this->getTitle()}</h3>\n$output</form>\n";
 }
}