<?php
require_once("Sub.php");

class TurkeySub extends Sub
{

    protected function addPrimaryTopping(){
        var_dump("Putting some turkey");
        return $this;
    }

}