<?php
require_once("InputFormat.php");

/**
 * The Base Decorator - it does not contain any real filtering
 * or formatting logic. It just delegates the core functionality
 * to the wrapped object. The real formatting it's done by the
 * subclasses
 * Class TextFormatBase
 */
class TextFormatBase implements InputFormat
{
    protected $inputFormat;

    /**
     * TextFormatBase constructor.
     * @param InputFormat $inputFormat
     */
    public function __construct(InputFormat $inputFormat)
    {
        $this->inputFormat = $inputFormat;
    }

    /**
     * @param $text
     * @return string
     */
    public function formatText($text)
    {
        return $this->inputFormat->formatText($text);
    }
}