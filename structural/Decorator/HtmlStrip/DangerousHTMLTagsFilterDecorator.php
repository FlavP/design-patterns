<?php
require_once('TextFormatBase.php');

/**
 * his Concrete Decorator strips only dangerous HTML tags and attributes that
 * may lead to an XSS vulnerability.
 * Class DangerousHTMLTagsFilterDecorator
 */
class DangerousHTMLTagsFilterDecorator extends TextFormatBase
{
    private $dangerousTagPatterns = [
        "|<script.*?>([\s\S]*)?</script>|i",
    ];

    private $dangerousAttributes = [
        "onclick", "onkeypress",
    ];

    /**
     * @param $text
     * @return string
     */
    public function formatText($text)
    {
        $text = parent::formatText($text);

        foreach ($this->dangerousTagPatterns as $pattern) {
            $text = preg_replace($pattern, '', $text);
        }

        foreach ($this->dangerousAttributes as $attribute){
            $text = preg_replace_callback('|<(.*?)>|', function ($matches) use ($attribute){
                $result = preg_replace("|$attribute=|i", '', $matches[1]);
                return "<" . $result . ">";
            }, $text);
        }
        return $text;
    }
}