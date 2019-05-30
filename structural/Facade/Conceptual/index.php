<?php

/**
 * It provides a simplified Customer interface with 1 or more complex subsystems
 * Class Facade
 */
class Facade{
    protected $subsystem1;
    protected $subsystem2;

    /**
     * If there are no subsystems initialized, they are instantiated in the constructor
     * Facade constructor.
     * @param Subsystem1|null $subsystem1
     * @param Subsystem2|null $subsystem2
     */
    public function __construct(Subsystem1 $subsystem1 = null, Subsystem2 $subsystem2 = null)
    {
        $this->subsystem1 = $subsystem1 ? $subsystem1 : new Subsystem1;
        $this->subsystem2 = $subsystem2 ? $subsystem2 : new Subsystem2;
    }

    public function operation(){
        $result = "Facade initializes subsystems:\n";
        $result .= $this->subsystem1->operation1();
        $result .= $this->subsystem2->operation1();
        $result .= "Facade orders subsystems to perform the action:\n";
        $result .= $this->subsystem1->operationN();
        $result .= $this->subsystem2->operationZ();
        return $result;
    }
}

class Subsystem1{
    public function operation1(){
        return "Starting engines in Subsystem 1\n";
    }

    public function operationN(){
        return "Subsystem1: GO! \n";
    }
}

class Subsystem2{
    public function operation1(){
        return "Starting engines in Subsystem 2\n";
    }

    public function operationZ(){
        return "Subsystem2: Fire! \n";
    }
}
function clientCode(Facade $facade){
    echo $facade->operation();
}

$subsystem1 = new Subsystem1();
$subsystem2 = new Subsystem2();
$facade = new Facade($subsystem1, $subsystem2);
clientCode($facade);