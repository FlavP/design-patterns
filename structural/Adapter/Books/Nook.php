<?php
require_once("EReaderInterface.php");

class Nook implements EReaderInterface
{
    public function turnOn()
    {
        var_dump("Turn the Nook on.\n");
    }

    public function pressNextButton()
    {
        var_dump("Press the next button.\n");
    }

}