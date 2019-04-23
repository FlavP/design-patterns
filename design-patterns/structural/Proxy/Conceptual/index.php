<?php

interface Subject{
    public function request();
}

class RealSubject implements Subject{
    public function request()
    {
        echo "Request method called from the Original class\n";
    }
}

class ProxySubject implements Subject{
    private $subject;

    public function __construct(RealSubject $subject)
    {
        $this->subject = $subject;
    }

    public function request()
    {
        if ($this->hasAccess()){
            $this->subject->request();
            $this->logAccess();
        }
    }

    public function hasAccess(){
        echo "Proxy: Checking access prior to firing a real request.\n";
        return true;
    }

    public function logAccess(){
        echo "Proxy: Logging the time of request.\n";
    }
}

function clientCode(Subject $subject){
    $subject->request();
}

echo "Using a real subject \n";
$normalSubject = new RealSubject();
clientCode($normalSubject);

echo "Using a proxy subject \n";
$proxySubject = new ProxySubject($normalSubject);
clientCode($proxySubject);
