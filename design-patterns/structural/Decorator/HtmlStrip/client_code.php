<?php
require_once('TextFormatBase.php');
require_once('MarkDownFormatDecorator.php');
require_once('DangerousHTMLTagsFilterDecorator.php');
require_once('TextInput.php');
require_once('PlainTextFilterDecorator.php');

function displayComment(InputFormat $format, $text){
    echo $format->formatText($text);
}

$dangerousComment = <<<HERE
Hello! Nice blog post!
Please visit my <a href='http://www.iwillhackyou.com'>homepage</a>.
<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

/**
 * Naive comment rendering (unsafe)
 */
$naiveInput = new TextInput();
echo "Website renders comments without filtering (unsafe):\n";
displayComment($naiveInput, $dangerousComment);
echo "<br><br>";

/**
 * Filtered (safe)
 */
$filteredInput = new PlainTextFilterDecorator($naiveInput);
echo "Website renders comments after stripping all tags (safe):\n";
displayComment($filteredInput, $dangerousComment);
echo "<br><br>";

/**
 * Decorator allows stacking multiple input formats to get fine-grained control
 * over the rendered content.
 */
$dangerousForumPost = <<<HERE
# Welcome

This is my first post on this **gorgeous** forum.

<script src="http://www.iwillhackyou.com/script.js">
  performXSSAttack();
</script>
HERE;

/**
 * Naive post rendering (unsafe, no formatting).
 */
$naiveInput = new TextInput;
echo "Website renders a forum post without filtering and formatting (unsafe, ugly):\n";
displayComment($naiveInput, $dangerousForumPost);
echo "<br><br>";

/**
 * Markdown formatter + filtering dangerous tags (safe, pretty).
 */
$text = new TextInput();
$markdown = new MarkDownFormatDecorator($text);
$filteredInput = new DangerousHTMLTagsFilterDecorator($markdown);
echo "Website renders a forum post after translating markdown markup" .
    "and filtering some dangerous HTML tags and attributes (safe, pretty):\n";
displayComment($filteredInput, $dangerousForumPost);
echo "<br><br>";
