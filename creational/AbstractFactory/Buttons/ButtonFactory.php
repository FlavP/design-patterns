<?php

interface Button{
    public function render();
}

abstract class ButtonFactory{
    abstract function createSubmitButton();
    abstract function createResetButton();
}

class SubmitButton implements Button{
    private $provider;
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function render(){
        echo "This is a Submit Button from " . $this->provider . "\n";
    }
}

class ResetButton implements Button{
    private $provider;
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function render(){
        echo "This is a Reset Button from " . $this->provider . "\n";
    }
}

class AlupigusFactory extends ButtonFactory{
    public function createSubmitButton(){
        return new SubmitButton("Alupigus");
    }

    public function createResetButton(){
        return new ResetButton("Alupigus");
    }
}

class JohnDoeFactory extends ButtonFactory{
    public function createSubmitButton(){
        return new SubmitButton("JohnDoe");
    }

    public function createResetButton(){
        return new ResetButton("JohnDoe");
    }
}

$alupigusFactory = new AlupigusFactory();
$alupigusSubmitButton = $alupigusFactory->createSubmitButton();
$alupigusSubmitButton->render();
$alupigusResetButton = $alupigusFactory->createResetButton();
$alupigusResetButton->render();

$johndoeFactory = new JohnDoeFactory();
$johndoeSubmitButton = $johndoeFactory->createSubmitButton();
$johndoeSubmitButton->render();
$johndoeResetButton = $johndoeFactory->createResetButton();
$johndoeResetButton->render();