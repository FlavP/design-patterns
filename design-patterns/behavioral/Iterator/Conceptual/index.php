<?php

//Facem o clasa care itereaza printr-o colectie de cuvinte
//In ordine normala sau inversa
/**
 * Concrete Iterators implement various traversal algorithms. These classes
 * store the current traversal position at all times.
 */
class WordIterator implements \Iterator {
    /**
     * @var WordsCollection
     */
    private $collection;
    private $reverse;
    private $position = 0;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    // voi avea 4 metode care imi returneaza pozitia curenta, cheia, primul element, urmatorul element
    public function rewind()
    {
        // Collection's starting position
        $this->position = $this->reverse ? count($this->collection) - 1 : 0;
    }

    public function key()
    {
        return $this->position;
    }

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function next()
    {
        $this->position = $this->position + ($this->reverse ? -1 : +1);
    }

    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

/**
 * Concrete Collections provide one or several methods for retrieving fresh
 * iterator instances, compatible with the collection class.
 */
class WordsCollection implements \IteratorAggregate{
    //cream getter si add item, de asemenea 2 metode, una care returneaza un iterator normal, alta un iterator reverse
    private $items = [];

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getIterator()
    {
        return new WordIterator($this);
    }

    public function getReverseIterator(){
        return new WordIterator($this, true);
    }
}

// Pentru codul de implementare intai cream o colectie, ii adaugam niste elemente, apoi
// folosim cele 2 iteratoare, parcurgem colectiile si le afisam.

$collection = new WordsCollection();
$collection->addItem('First');
$collection->addItem('Second');
$collection->addItem('Third');

echo "Straight traversal:\n";
foreach ($collection->getIterator() as $item)
    echo $item . '<br>';

echo "Reverse traversal:\n";
foreach ($collection->getReverseIterator() as $item)
    echo $item . '<br>';

