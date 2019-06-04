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

//$context = new InterpreterContext();
//$someVar = new VariableExpression('input', 'four');
//$someVar->interpret($context);
//print $context->lookup($someVar) . "\n";
//
//
//$newvar = new VariableExpression('input');
//$newvar->interpret($context);
//print $context->lookup($newvar) . "\n";
//
//$someVar->setValue('five');
//$someVar->interpret($context);
//print $context->lookup($someVar) . "\n";
//print $context->lookup($newvar) . "\n";

abstract class OperatorExpression extends Expression {
    private $l_op;
    private $r_op;

    public function __construct(Expression $l_op, Expression $r_op)
    {
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }

    public function interpret(InterpreterContext $context)
    {
        $this->r_op->interpret($context);
        $this->l_op->interpret($context);
        $result_l = $context->lookup($this->l_op);
        $result_r = $context->lookup($this->r_op);

        $this->doInterpret($context, $result_l, $result_r);
    }

    abstract protected function doInterpret(
        InterpreterContext $context,
        $result_l,
        $result_r
    );
}

class EqualsExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        $context->replace($this, $result_r == $result_l);
    }
}

class BooleanOrExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        $context->replace($this, $result_r || $result_l);
    }
}

class BooleanAndExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        $context->replace($this, $result_r && $result_l);
    }
}

$context = new InterpreterContext();
$input = new VariableExpression('input');
$statement = new BooleanOrExpression(
    new EqualsExpression($input, 'four'),
    new EqualsExpression($input, '4')
);


foreach (["four", "4", "52"] as $item) {
    $input->setValue($item);
    print "$item:\n";
    $statement->interpret($context);
    if ($context->lookup($statement))
        print "Yes\n\n\n";
    else
        print "No\n\n\n";
}
