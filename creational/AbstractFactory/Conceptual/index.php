<?php

interface AbstractProductFactory{
    public function createProductA();
    public function createProductB();
}

class ConcreteProductFactory1 implements AbstractProductFactory{
    public function createProductA()
    {
        return new ConcreteProductA1;
    }

    public function createProductB()
    {
        return new ConcreteProductB1;
    }
}

class ConcreteProductFactory2 implements AbstractProductFactory{
    public function createProductA()
    {
        return new ConcreteProductA2;
    }

    public function createProductB()
    {
        return new ConcreteProductB2;
    }
}

interface AbstractProductA{
    public function usefulFunctionA();
}

class ConcreteProductA1 implements AbstractProductA{
    public function usefulFunctionA()
    {
        return "The result of the product A1.";
    }
}

class ConcreteProductA2 implements AbstractProductA{
    public function usefulFunctionA()
    {
        return "The result of the product A2.";
    }
}

interface AbstractProductB{
    /**
     * Product B is able to do its own thing...
     */
    public function usefulFunctionB();

    /**
     * ...but it also can collaborate with the ProductA.
     *
     * The Abstract Factory makes sure that all products it creates are of the
     * same variant and thus, compatible.
     */
    public function anotherUsefulFunctionB(AbstractProductA $collaborator);
}

class ConcreteProductB1 implements AbstractProductB{
    public function usefulFunctionB()
    {
        return "The result of the product B1.";
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator)
    {
        $result = $collaborator->usefulFunctionA();
        return "The result of the B1 collaborating with the ({$result})";
    }
}

class ConcreteProductB2 implements AbstractProductB{
    public function usefulFunctionB()
    {
        return "The result of the product B2.";
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator)
    {
        $result = $collaborator->usefulFunctionA();
        return "The result of the B2 collaborating with the ({$result})";
    }
}

function clientCode(AbstractProductFactory $factory){
    $productA = $factory->createProductA();
    $productB = $factory->createProductB();

    echo $productB->usefulFunctionB() . "\n";
    echo $productB->anotherUsefulFunctionB($productA) . "\n";
}

echo "Client: Testing client code with the first factory type:\n";

clientCode(new ConcreteProductFactory1());

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";

clientCode(new ConcreteProductFactory2());