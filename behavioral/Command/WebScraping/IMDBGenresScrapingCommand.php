<?php
require_once("WebScrappingCommand.php");

class IMDBGenresScrapingCommand extends WebScrappingCommand
{
    public function __construct()
    {
        $this->url = "https://www.imdb.com/feature/genre/";
    }

    public function parse($html)
    {
        preg_match_all("|href=\"(https://www.imdb.com/search/title\?genres=.*?)\"|", $html, $matches);
        echo "IMDBGenresScrapingCommand: Discovered " . count($matches[1]) . " genres";
        foreach ($matches[1] as $genre){
            Queue::get()->add(new IMDBGenrePageScrapingCommand($genre));
        }
    }
}