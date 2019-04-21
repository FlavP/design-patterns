<?php
require_once('TextFormatBase.php');

class DangerousHTMLTagsFilterDecorator extends TextFormatBase
{
    private $dangerousTagPatterns = [
        "|<script.*?>([\s\S]*)?</script>|i",
    ];

    private $dangerousAttributes = [
        "onclick", "onkeypress",
    ];

    public function formatText($text)
    {
        $text = parent::formatText($text);

        foreach ($this->dangerousTagPatterns as $pattern) {
            $text = preg_replace($pattern, '', $text);
        }
    }
}