<?php

function getProductFileLines($filename){
    return file($filename);
}

function getProductObjectFromId($id, $productname){
    return new Product($id, $productname);
}

function getNameFromLine($line){
    if (preg_match("/.*-(.*)\s\d+/", $line, $array))
        return str_replace("_", " ", $array[1]);
    return '';
}

function getIdFromLine($line){
    if (preg_match("/^(\d{1,3})-/", $line, $array))
        return $array[1];
    return -1;
}

class Product{
    private $id;
    private $name;
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
}

class ProductFacade{
    private $products = [];
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
        $this->compile();
    }

    public function compile(){
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line){
            $id = getIdFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromId($id, $name);
        }
    }

    public function getProducts(){
        return $this->products;
    }

    public function getProduct($id){
        if (isset($this->products[$id]))
            return $this->products[$id];
        return null;
    }
}

$facade = new ProductFacade( __DIR__ . "/file.txt" );
$product = $facade->getProduct(234);

echo $product->getName() . "\n";
