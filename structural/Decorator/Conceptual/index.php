<?php

/**
 * The base Component interface
 * defines the operations that can be altered
 * by decorators
 * Interface Component
 */
interface Component{
    public function operation();
}

/**
 * Default implementations of the operations
 * There migh be several variations of these classes
 * Class ConcreteComponent
 */
class ConcreteComponent implements Component{

    /**
     * @return string
     */
   public function operation()
   {
       return "ConcreteComponent";
   }
}

/**
 * The Base Decorator Class follows the same interface
 * It defines the wrapping interface for all concrete
 * decorators. It might include a field for storing
 * a wrapped component and the means to initialize it
 * Class Decorator
 */
class Decorator implements Component{

    protected $component;

    /**
     * Decorator constructor.
     * @param Component $component
     */
    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    /**
     * The decorator delegates all work to the wrapped component
     * @return string
     */
    public function operation()
    {
        return $this->component->operation();
    }
}

/**
 * Concrete Decorators call the wrapped object and alter its result in some way
 * Class ConcreteDecoratorA
 */
class ConcreteDecoratorA extends Decorator{
    public function operation()
    {
        return "ConcreteDecoratorA( " . parent::operation() . " )";
    }
}

/**
 * Decorators can execute their behavior either before or after the call
 * to a wrapped object
 * Class ConcreteDecoratorB
 */
class ConcreteDecoratorB extends Decorator{
    public function operation()
    {
        return "ConcreteDecoratorB( " . parent::operation() . " )";
    }
}

/**
 * The client code works with all objects that implement the
 * Component interface
 * @param Component $component
 */
function clientCode(Component $component){
    echo "Result: " . $component->operation();
}

/**
 * This way the client code can support both simple components...
 */
$simple = new ConcreteComponent();
echo "Client: I've got a simple component:\n";
clientCode($simple);
echo "<br><br>";

/**
 * ...as well as decorated ones.
 *
 * Note how decorators can wrap not only simple components but the other
 * decorators as well.
 */
$decorator1 = new ConcreteDecoratorA($simple);
$decorator2 = new ConcreteDecoratorB($decorator1);
echo "Client: Now I've got a decorated component:\n";
clientCode($decorator2);