<?php

// Vom implementa 2 interfete, una pentru Subject (cel care e observat)
// Si una pentru Observer
// Subject va avea observers asociati si un state pe care il vom initializa in a 4-a metoda
// SomebusinessLogic

class Subject implements \SplSubject{
    protected $state;
    protected $observers;

    public function __construct()
    {
        $this->observers =  new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        echo "An observer has been attached <br>";
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
        echo "An observer has been detached <br>";
    }

    public function notify()
    {
        echo "Subject: Notifying observers...<br>";
        foreach ($this->observers as $observer)
            $observer->update($this);
    }

    public function someBusinessLogic(){
        echo "<br>Subject: I'm doing something important.<br>";
        $this->state = rand(0, 10);
        echo "Subject: My state has just changed to: {$this->state}<br>";
        $this->notify();
    }
}

class ConcreteObserverA implements \SplObserver{
    public function update(SplSubject $subject)
    {
        if ($subject->state < 3) {
            echo "ConcreteObserverA: Reacted to the event.<br>";
        }
    }
}

class ConcreteObserverB implements \SplObserver{
    public function update(SplSubject $subject)
    {
        if ($subject->state == 0 || $subject->state >= 2) {
            echo "ConcreteObserverB: Reacted to the event.<br>";
        }
    }
}

/**
 * Client Code
 */
$subject = new Subject();
$observer1 = new ConcreteObserverA();
$observer2 = new ConcreteObserverB();
$subject->attach($observer1);
$subject->attach($observer2);
$subject->someBusinessLogic();
$subject->someBusinessLogic();
$subject->detach($observer1);
$subject->someBusinessLogic();
