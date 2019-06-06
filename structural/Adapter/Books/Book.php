<?php
require_once('BookInterface.php');

class Book implements BookInterface
{
    public function open()
    {
        var_dump("Opening the book.\n");
    }

    public function turnPage()
    {
        var_dump("Turning the page.\n");
    }

}