<?php
require_once('Middleware.php');

/**
 * This is a class that acts as an actual. It uses the CoR pattern to execute
 * several authentication middlewares before launching some business logic
 * associated with a request.
 * Class Server
 */
class Server
{
    private $users = [];
    /**
     * @var Middleware
     */
    private $middleware;

    /**
     * The user can associate the preferred middleware to the class
     * @param Middleware $middleware
     */
    public function setMiddleware(Middleware $middleware){
        $this->middleware = $middleware;
    }

    /**
     * The server gets the email and password from the client and sends the
     * authorization request to the middleware.
     * @param $email
     * @param $password
     */
    public function login($email, $password){
        if ($this->middleware->check($email, $password)){
            echo "Server: Authorization has been successful!\n";
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @param $password
     */
    public function register($email, $password){
        $this->users[$email] = $password;
    }

    /**
     * @param $email
     * @return bool
     */
    public function hasEmail($email){
        return isset($this->users[$email]);
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function hasValidPassword($email, $password){
        return ($this->users[$email] === $password);
    }
}