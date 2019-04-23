<?php

interface Handler{
    public function next(Handler $handler);
    public function handle($request);
}

class BaseHandler implements Handler{
    private $next;

    /**
     * Return the handler object for chaining
     * @param Handler $handler
     * @return Handler
     */
    public function next(Handler $handler)
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle($request)
    {
        if($this->next->handle($request))
            return $this->next->handle($request);
        return null;
    }
}

class MonkeyHandler extends BaseHandler{
    public function handle($request)
    {
        if($request === "Banana"){
            return "Monkey, I will eat the " . $request . "\n";
        } else {
            return parent::handle($request);
        }
    }
}

class SquirrelHandler extends BaseHandler{
    public function handle($request)
    {
        if($request === "Peanut"){
            return "Squirrel, I will eat the " . $request . "\n";
        } else {
            return parent::handle($request);
        }
    }
}

class DogHandler extends BaseHandler{
    public function handle($request)
    {
        if($request === "MeatBall"){
            return "Dog, I will eat the " . $request . "\n";
        } else {
            return parent::handle($request);
        }
    }
}

function clientCode(Handler $handler){
    foreach (['Peanut', 'Banana, Biscuits'] as $food){
        echo "Client: Who wants a " . $food . "?\n";
        $result = $handler->handle($food);
        if($result)
            echo " " . $result;
        else
            echo " " . $food . "was left untouched.\n";
    }
}

/**
 * The other part of the client code constructs the actual chain.
 */
$monkey = new MonkeyHandler();
$squirrel = new SquirrelHandler();
$dog = new DogHandler();

$monkey->next($squirrel)->next($dog);
/**
 * The client should be able to send a request to any handler, not just the
 * first one in the chain.
 */
echo "Chain: Monkey > Squirrel > Dog\n\n";
clientCode($monkey);
echo "\n";

echo "Subchain: Squirrel > Dog\n\n";
clientCode($squirrel);