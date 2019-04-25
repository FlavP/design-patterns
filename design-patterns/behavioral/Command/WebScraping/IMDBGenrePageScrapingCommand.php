<?php
require_once("WebScrappingCommand.php");

class IMDBGenrePageScrapingCommand extends WebScrappingCommand
{
    private $page;
    public function __construct($url, $page = 1)
    {
        parent::__construct($url);
        $this->page = $page;
    }

    public function parse($html)
    {
        
    }
}