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
        $result = '';
    }
}