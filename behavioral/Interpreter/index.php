<?php

abstract class Expression{
    private static $keycount = 0;
    private $key;

    abstract function interpret(InterpreterContext $context);

    public function getKey(){
        if(!isset($this->key)){
            self::$keycount++;
            $this->key = self::$keycount;
        }
        return $this->key;
    }
}

class LiteralExpression extends Expression{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function interpret(InterpreterContext $context)
    {
        $context->replace($this, $this->value);
    }
}

class InterpreterContext{
    private $expressionstore = [];

    public function replace(Expression $expression, $value){
        $this->expressionstore[$expression->getKey()] = $value;
    }

    public function lookup(Expression $expression){
        return $this->expressionstore[$expression->getKey()];
    }
}

//$context = new InterpreterContext();
//$literal = new LiteralExpression("four");
//$literal->interpret($context);
//print $context->lookup($literal) . "\n";

class VariableExpression extends Expression {
    private $name;
    private $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function interpret(InterpreterContext $context)
    {
        if (!is_null($this->value)){
            $context->replace($this, $this->value);
            //Pentru a suprascrie valoarea in cazul in care vreau sa folosesc interpret cu alta valoare
            $this->value = null;
        }
    }

    public function getKey()
    {
        return $this->name;
    }

    public function setValue($value){
        $this->value = $value;
    }
}

$context = new InterpreterContext();
$someVar = new VariableExpression('input', 'four');
$someVar->interpret($context);
print $context->lookup($someVar) . "\n";


$newvar = new VariableExpression('input');
$newvar->interpret($context);
print $context->lookup($newvar) . "\n";

$someVar->setValue('five');
$someVar->interpret($context);
print $context->lookup($someVar) . "\n";
print $context->lookup($newvar) . "\n";
