<?php

abstract class Tile {
    abstract public function getWealthFactor();
}

class Plain extends Tile {
    private $wealthFactor = 2;

    public function getWealthFactor()
    {
        return $this->wealthFactor;
    }
}

abstract class TileDecorator extends Tile {
    protected $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator {

    public function getWealthFactor()
    {
        return $this->tile->getWealthFactor() + 2;
    }
}

class PolutionDecorator extends TileDecorator {

    public function getWealthFactor()
    {
        return $this->tile->getWealthFactor() - 4;
    }
}

$tile1 = new Plain();
print $tile1->getWealthFactor() . "\n";

$tile2 = new DiamondDecorator($tile1);
print $tile2->getWealthFactor() . "\n";

$tile3 = new PolutionDecorator(new DiamondDecorator($tile1));
print $tile3->getWealthFactor() . "\n";

