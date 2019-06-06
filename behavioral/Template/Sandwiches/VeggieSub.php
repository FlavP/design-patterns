<?php
require_once("Sub.php");

class VeggieSub extends Sub
{
    protected function addPrimaryTopping(){
        var_dump("Adding some vegetables");
        return $this;
    }

}