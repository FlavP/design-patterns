<?php

abstract class SocialNetworkPoster{
    abstract function getSocialNetwork();

    public function post(){
        $network = $this->getSocialNetwork();
        $network->logIn();
        $network->post($content);
        $network->logOut();
    }
}

class FacebookPoster extends SocialNetworkPoster {
    private $login;
    private $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork()
    {
        return new FacebookConnector($this->login, $this->password);
    }
}

class LinkedInPoster extends SocialNetworkPoster{
    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork(){
        return new LinkedInConnector($this->email, $this->password);
    }
}

interface SocialMediaConnectorInterface{
    public function logIn();
    public function logOut();
    public function post($content);
}

class FacebookConnector implements SocialMediaConnectorInterface{
    private $login;
    private $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function logIn()
    {
        echo "Send HTTP API request to log in user $this->login with " .
            "password $this->password\n";
    }

    public function logOut()
    {
        echo "Send HTTP API request to log out user $this->login\n";
    }

    public function post($content)
    {
        echo "Send HTTP API requests to create a post in Facebook timeline.\n";
    }
}

class LinkedInConnector implements SocialMediaConnectorInterface{
    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function logIn()
    {
        echo "Send HTTP API request to log in user $this->email with " .
            "password $this->password\n";
    }

    public function logOut()
    {
        echo "Send HTTP API request to log out user $this->email\n";
    }

    public function post($content)
    {
        echo "Send HTTP API requests to create a post in LinkedIn timeline.\n";
    }
}

function clientCode(SocialNetworkPoster $poster){
    $poster->post("Some random \n");
    $poster->post("Some random random stuff \n");
}

echo "Testing ConcreteCreator1:\n";
clientCode(new FacebookPoster("User1", "*****"));
echo "\n\n";

echo "Testing ConcreteCreator2:\n";
clientCode(new LinkedInPoster("User@yahoo.com", "*****"));
