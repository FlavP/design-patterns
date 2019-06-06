<?php


abstract class Sub
{
    public function make() {
        return $this
            ->layBread()
            ->addPrimaryTopping()
            ->addLettuce()
            ->addSauce();
    }

    protected function layBread(){
        var_dump("Laying the bread");
        return $this;
    }

    protected function addLettuce(){
        var_dump("Adding the lettuce");
        return $this;
    }

    protected function addSauce(){
        var_dump("Putting some sauce");
        return $this;
    }

    abstract protected function addPrimaryTopping();
}