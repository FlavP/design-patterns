<?php

class Car{
    private $color;
    private $wheels;

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getWheels()
    {
        return $this->wheels;
    }

    /**
     * @param mixed $wheels
     */
    public function setWheels($wheels)
    {
        $this->wheels = $wheels;
    }

    public function showCar(){
        echo "This " . $this->color . " car has " . $this->wheels . " wheels \n";
    }
}

interface CarBuilderInterface{
    public function setWheels($wheels);
    public function setColor($color);
    public function getResult();
}

class CarBuilder implements CarBuilderInterface{
    private $car;

    public function __construct()
    {
        $this->car = new Car();
    }

    public function setWheels($wheels){
        $this->car->setWheels($wheels);
        return $this;
    }

    public function setColor($color){
        $this->car->setColor($color);
        return $this;
    }

    public function getResult(){
        return $this->car;
    }
}

class CarBuilderDirector{
    private $builder;

    public function __construct(CarBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function build(){
        $this->builder->setColor('Red');
        $this->builder->setWheels(4);
        return $this;
    }

    public function getCar(){
        return $this->builder->getResult();
    }
}

//Client
$carBuilder = new CarBuilder();
$CarBuilderDirector = new CarBuilderDirector($carBuilder);
$car = $CarBuilderDirector->build()->getCar();
$car->showCar();