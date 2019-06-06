<?php
require_once("EReaderInterface.php");

class Kindle implements EReaderInterface
{
    public function turnOn()
    {
        var_dump("Turn the Kindle on.\n");
    }

    public function pressNextButton()
    {
        var_dump("Press the next button.\n");
    }

}