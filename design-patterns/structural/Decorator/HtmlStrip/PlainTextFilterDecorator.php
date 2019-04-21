<?php
require_once('TextFormatBase.php');

/**
 * Concrete Decorator that extends the base decorator and strips all the HTML tags from a given text
 * Class PlainTextFilterDecorator
 */
class PlainTextFilterDecorator extends TextFormatBase
{
    public function formatText($text)
    {
        $text = parent::formatText($text);
        return strip_tags($text);
    }
}