<?php
require_once("Command.php");

abstract class WebScrappingCommand implements Command
{
    public $id;
    public $status = 0;
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function execute()
    {
       $html = $this->download();
       $this->parse($html);
       $this->complete();
    }

    public function download(){
        $html = file_get_contents($this->getUrl());
        echo "WebScrappingCommand: Downloaded {$this->url}\n";
        return $html;
    }

    abstract function parse($html);

    public function complete(){
        $this->status = 1;
        Queue::get()->completeCommand($this);
    }

}