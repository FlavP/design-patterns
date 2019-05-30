<?php

interface Product{
    public function getType();
}

interface ProductFactory{
    public function makeProduct();
}

class SimpleProduct implements Product{
    public function getType(){
        return "SimpleProduct";
    }
}

class SimpleProductFactory implements ProductFactory {
    public function makeProduct(){
        return new SimpleProduct();
    }
}

$simpleFac = new SimpleProductFactory();
$product = $simpleFac->makeProduct();
echo $product->getType();