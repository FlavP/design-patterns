<?php

interface CarService{
    public function getCost();
}

class BasicInspection implements CarService {
    public function getCost() {
        return 19;
    }
}

class OilChange implements CarService {
    private $service;

    public function __construct(CarService $service)
    {
        $this->service = $service;
    }

    public function getCost()
    {
        return 25 + $this->service->getCost();
    }
}

echo (new OilChange(new BasicInspection()))->getCost();