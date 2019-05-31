<?php

abstract class Unit
{

    public function getComposite()
    {
        return null;
    }

    abstract public function bombardStrength();
}

abstract class CompositeUnit extends Unit
{

    /**
     * @var Unit[]
     */
    private $units = [];

    public function getComposite()
    {
        return $this;
    }

    public function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true))
            return;
        $this->units[] = $unit;
    }

    public function removeUnit(Unit $unit)
    {
        $idx = array_search($unit, $this->units);
        if (is_int($idx))
            array_splice($this->units, $idx, 1, []);
    }

    /**
     * @return Unit[]
     */
    public function getUnits()
    {
        return $this->units;
    }
}

class Army extends CompositeUnit
{

    public function bombardStrength()
    {
        $res = 0;
        foreach (parent::getUnits() as $unit){
            $res += $unit->bombardStrength();
        }
        return $res;
    }
}

class Archer extends Unit
{
    public function bombardStrength()
    {
        return 4;
    }
}

class LaserCannon extends Unit
{
    public function bombardStrength()
    {
        return 22;
    }
}

class UnitScript
{
    public function joinExisting(Unit $newUnit, Unit $existingUnit)
    {
        $comp = $existingUnit->getComposite();
        if (!is_null($comp))
            $comp->addUnit($newUnit);
        else {
            $comp = new Army();
            $comp->addUnit($existingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
    }
}

$main_army = new Army();

$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannon());

$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

$main_army->addUnit($sub_army);

print "Attacking strenth: {$main_army->bombardStrength()}\n";
