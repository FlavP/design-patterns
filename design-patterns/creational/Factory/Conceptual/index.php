<?php
abstract class Creator{
    abstract function factoryMethod();
    public function someOperation(){
        $product = $this->factoryMethod();
        $result = "" . $product->operation();
        return $result;
    }
}
class ConcreteCreator1 extends Creator{
    public function factoryMethod()
    {
        return new ConcreteProduct1();
    }
}
class ConcreteCreator2 extends Creator{
    public function factoryMethod()
    {
        return new ConcreteProduct2();
    }
}
interface ProductInterface{
    public function operation();
}
class ConcreteProduct1 implements ProductInterface {
    public function operation()
    {
        return "{Result of the ConcreteProduct1}";
    }
}
class ConcreteProduct2 implements ProductInterface {
    public function operation()
    {
        return "{Result of the ConcreteProduct2}";
    }
}
function clientCode(Creator $creator){
    echo "Client: I'm not aware of the creator's class, but it still works.\n " . $creator->someOperation();
}
echo "App: Launched with the ConcreteCreator1.\n";
clientCode(new ConcreteCreator1);
echo "\n\n";
echo "App: Launched with the ConcreteCreator2.\n";
clientCode(new ConcreteCreator2);
