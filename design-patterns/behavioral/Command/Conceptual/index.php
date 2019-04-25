<?php

interface Command{
    public function execute();
}

/**
 * Class SimpleCommand
 */
class SimpleCommand implements Command {
    private $payload;

    /**
     * Ii dai niste parametri comenzii si ii afisezi
     * SimpleCommand constructor.
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function execute()
    {
        echo "SimpleCommand: See, I can do simple things like printing (" . $this->payload . ")\n";
    }
}

/**
 * Some complex commands can delegate their work to other objects called receivers
 * Class ComplexCommand
 */
class ComplexCommand implements Command {
    private $a, $b, $receiver;

    /**
     * ComplexCommand constructor.
     * @param Receiver $receiver
     * @param string $a
     * @param string $b
     */
    public function __construct(Receiver $receiver, $a, $b)
    {
        $this->receiver = $receiver;
        $this->a = $a;
        $this->b = $b;
    }

    public function execute()
    {
        echo "ComplexCommand: Complex stuff should be done by a receiver object.\n";
        $this->receiver->doSomething($this->a);
        $this->receiver->doSomethingElse($this->b);
    }
}

/**
 * Classes that do concrete work. They receive the command and do actual work
 * Class Receiver
 */
class Receiver{
    /**
     * @param string $a
     */
    public function doSomething($a){
        echo "Receiver: Working on (" . $a . ".)\n";
    }

    /**
     * @param string $b
     */
    public function doSomethingElse($b){
        echo "Receiver: Also working on (" . $b . ".)\n";
    }
}

/**
 * The Invoker is associated with one or more Commands. It sends a request to the command.
 * Class Invoker
 */
class Invoker {
    private $doBefore;
    private $doAfter;

    /**
     * @param Command $doAfter
     */
    public function setDoAfter(Command $doAfter)
    {
        $this->doAfter = $doAfter;
    }

    /**
     * @param Command $doBefore
     */
    public function setDoBefore(Command $doBefore)
    {
        $this->doBefore = $doBefore;
    }

    public function doSomethingImportant(){
        if(isset($this->doBefore)){
            echo "Executing a Command at the start of the function\n";
            $this->doBefore->execute();
        }
        echo "Invoker: ...doing something really important...\n";
        if(isset($this->doAfter)){
            echo "Executing a Command at the end of the function\n";
            $this->doAfter->execute();
        }
    }
}

// Construim un invoker, apelam o comanda simpla la inceput
// Construim un receiver si apelam o comanda la sfarsit

$invoker = new Invoker();
$invoker->setDoBefore(new SimpleCommand());
$receiver = new Receiver();
$invoker->setDoAfter(new ComplexCommand($receiver, "Do First", "Do After"));
$invoker->doSomethingImportant();