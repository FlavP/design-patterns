<?php
require_once ('FieldComposite.php');

/**
 * Fieldset is a concrete Composite
 * Class Fieldset
 */
class Fieldset extends FieldComposite
{
    /**
     * @return string
     */
    public function render()
    {
        $output = parent::render();
        return "<fieldset><legend>{$this->getTitle()}</legend>\n$output</fieldset>\n";
    }
}