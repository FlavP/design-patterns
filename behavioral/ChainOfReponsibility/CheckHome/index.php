<?php

abstract class HomeChecker {
    protected $successor;

    public abstract function check(HomeStatus $home);

    public function setSuccessor(HomeChecker $successor){
        $this->successor = $successor;
    }

    public function next(HomeStatus $home){
        if ($this->successor !== null)
            $this->successor->check($home);
    }
}

class Locks extends HomeChecker {
    public function check(HomeStatus $home){
        if(!$home->locked){
            throw new Exception("The doors are not locked! Lock the doors! \n");
        }

        $this->next($home);
    }
}

class Lights extends HomeChecker {
    public function check(HomeStatus $home){
        if(!$home->lightsOff){
            throw new Exception("The light are still on! Turn off the lights! \n");
        }

        $this->next($home);
    }
}

class Alarms extends HomeChecker {
    public function check(HomeStatus $home){
        if(!$home->alarmOn){
            throw new Exception("The alarm has not been set! Set the alarm! \n");
        }

        $this->next($home);
    }
}

class HomeStatus {
    public $alarmOn = true;
    public $locked = false;
    public $lightsOff = true;
}

$locks = new Locks();
$lights = new Lights();
$alarms = new Alarms();

$locks->setSuccessor($lights);
$lights->setSuccessor($alarms);

$locks->check(new HomeStatus());