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

    public function getUrl()
    {
        return $this->url . '?page=' . $this->page;
    }

    /**
     * Extract all movies from a page like this:
     * https://www.imdb.com/search/title?genres=sci-fi&explore=title_type,genres
     */
    public function parse($html)
    {
        // Iau o pagina de filme
        preg_match_all("|href=\"(/title/.*?/)\?ref_=adv_li_tt\"|", $html, $matches);
        echo "IMDBGenrePageScrapingCommand: Discovered " . count($matches[1]) . " movies.\n";

        // Pentru fiecare pagina
        foreach ($matches[1] as $moviePage){
            // Iau pagina unui film
            $link = "https://www.imdb.com" . $moviePage;
            // Si o adaug intr-o baza de date
            Queue::get()->add(new IMDBMovieScrapingCommand($link));
        }

        // Daca mai exista pagini cu filme
        if (preg_match("|Next &#187;</a>|", $html)){
            // Trec la urmatoarea pagina
            Queue::get()->add(new IMDBGenrePageScrapingCommand($this->url, $this->page + 1));
        }
    }
}