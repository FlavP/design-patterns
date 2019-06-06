<?php

abstract class SocialNetwork {
    protected $username;
    protected $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function post($message) {
        if($this->logIn($this->username, $this->password)){
            $result = $this->sendData($message);
            $this->logOut();
            return $result;
        }
        return false;
    }

    abstract public function logIn($username, $password);
    abstract public function sendData($message);
    abstract public function logOut();
}

class Facebook extends SocialNetwork {
    public function logIn($username, $password)
    {
        echo "\nChecking user's credentials...\n";
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        simulateNetworkLatency();

        echo "\n\nFacebook: '" . $this->username . "' has logged in successfully.\n";
        return true;
    }

    public function sendData($message)
    {
        echo "Facebook: '" . $this->username . "' has posted '" . $message . "'.\n";

        return true;
    }

    public function logOut()
    {
        echo "Facebook: '" . $this->username . "' has been logged out.\n";
    }

}

class Twitter extends SocialNetwork {
    public function logIn($username, $password)
    {
        echo "\nChecking user's credentials...\n";
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        simulateNetworkLatency();

        echo "\n\nTwitter: '" . $this->username . "' has logged in successfully.\n";

        return true;
    }

    public function sendData($message)
    {
        echo "Twitter: '" . $this->username . "' has posted '" . $message . "'.\n";

        return true;
    }

    public function logOut()
    {
        echo "Twitter: '" . $this->username . "' has been logged out.\n";
    }

}

function simulateNetworkLatency() {
    $i = 0;
    while ($i < 5) {
        echo ".";
        sleep(1);
        $i++;
    }
}

echo "Username: \n";
$username = readline();
echo "Password: \n";
$password = readline();
echo "Message: \n";
$message = readline();

$facebookPoster = new Facebook($username, $password);
$facebookPoster->post($message);

$twitterUser = new Twitter($username, $password);
$twitterUser->post($message);