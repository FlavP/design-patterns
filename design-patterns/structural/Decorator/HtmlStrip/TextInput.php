<?php
require_once("InputFormat.php");

/**
 * The Concrete Component is a core element of decoration.
 * Class TextInput
 */
class TextInput implements InputFormat
{
    /**
     * It just returns the unformatted string
     * @param $text
     * @return string
     */
    public function formatText($text)
    {
        return $text;
    }
}