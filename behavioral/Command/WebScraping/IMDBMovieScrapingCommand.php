<?php
require_once("WebScrappingCommand.php");

/**
 * The Concrete Command for scraping the movie details.
 */
class IMDBMovieScrapingCommand extends WebScrappingCommand
{
    /**
     * Get the movie info from a page like this:
     * https://www.imdb.com/title/tt4154756/
     */
    public function parse($html)
    {
        if (preg_match("|<h1 itemprop=\"name\" class=\"\">(.*?)</h1>|", $html, $matches)) {
            $title = $matches[1];
        }
        echo "IMDBMovieScrapingCommand: Parsed movie $title.\n";
    }
}