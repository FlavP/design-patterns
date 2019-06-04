<?php

class Context {
    private $strategy;

    public function __construct(AlgorithmStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(AlgorithmStrategy $strategy){
        $this->strategy = $strategy;
    }

    public function doSomeBusinessLogic(){
        echo "Executing business logic accordind to an algorithm\n";
        $result = $this->strategy->executeAlgorithm(['d', 'f', 'b', 'n', 'g']);
        echo implode(',', $result) . "\n";
    }
}

interface AlgorithmStrategy{
    public function executeAlgorithm($arr);
}

class AlgorithmStrategyA implements AlgorithmStrategy {
    public function executeAlgorithm($arr)
    {
        sort($arr);
        return $arr;
    }
}

class AlgorithmStrategyB implements AlgorithmStrategy {
    public function executeAlgorithm($arr)
    {
        rsort($arr);
        return $arr;
    }
}

$clientCode = new Context(new AlgorithmStrategyA());
echo "First Strategy: \n";
$clientCode->doSomeBusinessLogic();

$clientCode->setStrategy(new AlgorithmStrategyB());
echo "Second Strategy: \n";
$clientCode->doSomeBusinessLogic();