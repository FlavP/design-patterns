<?php

/**
 * The base Component class declares common operations
 * for both simple and complex operations
 * Class Component
 */
abstract class Component {
    private $parent;

    /**
     * Optionally, you can implement an interface for accessing a parent in the tree
     * @return Component
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Component $parent
     */
    public function setParent(Component $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Optionally, you can have a method that says if a component can bear children
     * @return bool
     */
    public function isComposite()
    {
        return false;
    }

    /**
     * You can define the adding or removing functions in the base Component class
     * The downside is they are empty
     * @param Component $component
     */
    public function addChild(Component $component){}

    public function removeChild(Component $component){}

    /**
     * The Component may have a concrete default functionality, or it will be abstract and implemented by
     * the child classes
     * @return string
     */
    abstract function operation();
}

class Leaf extends Component {

    /**
     * The Leaf class represents the end objects of a composition. A leaf can't have
     * any children.
     *
     * Usually, it's the Leaf objects that do the actual work, whereas Composite
     * objects only delegate to their sub-components.
     * @return string
     */
    public function operation()
    {
        return "Leaf";
    }
}

class Composite extends Component{
    /**
     * @var \SplObjectStorage
     */
    protected $children;

    /**
     * Composite constructor.
     */
    public function __construct()
    {
        $this->children = new \SplObjectStorage();
    }

    /**
     * A composite object can add or remove other components (both simple or
     * complex) to or from its child list.
     * @param Component $component
     */
    public function addChild(Component $component)
    {
        $this->children->attach($component);
        $component->setParent($this);
    }

    public function removeChild(Component $component)
    {
        $this->children->detach($component);
        $component->setParent(null);
    }

    /**
     * The Composite executes its primary logic in a particular way. It
     * traverses recursively through all its children, collecting and summing
     * their results. Since the composite's children pass these calls to their
     * children and so forth, the whole object tree is traversed as a result.
     * @return string
     */
    public function operation()
    {
        $results = [];
        foreach ($this->children as $child){
            $results[] = $child->operation;
        }

        return "Branch(" . implode("+", $results) . ")";
    }
}

function clientCode(Component $component){
    echo "RESULT: " . $component->operation();
}

$tree = new Composite();
$branch1 = new Composite();
$branch1->addChild(new Leaf());
$branch1->addChild(new Leaf());
$branch2 = new Composite();
$tree->addChild($branch2);
$tree->addChild($branch1);

echo "Client: Now I've got a composite tree:\n";
clientCode($tree);
echo "\n\n";

function clientCode2(Component $component1, Component $component2){
    $component1->addChild($component2);
    echo "RESULT: " . $component1->operation();
}
$simple = new Leaf();
echo "Client: I don't need to check the components classes even when managing the tree:\n";
clientCode2($tree, $simple);




