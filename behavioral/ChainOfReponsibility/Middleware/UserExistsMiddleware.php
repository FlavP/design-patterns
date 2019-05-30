<?php
require_once('Server.php');
require_once('Middleware.php');

/**
 * Class UserExistsMiddleware
 */
class UserExistsMiddleware extends Middleware
{
    private $server;

    /**
     * UserExistsMiddleware constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Using the Server class to check the email and
     * @param $email
     * @param $password
     * @return bool
     */
    public function check($email, $password)
    {
        if (!$this->server->hasEmail($email))
            return false;
        if (!$this->server->hasValidPassword($email, $password))
            return false;
        return parent::check($email, $password);
    }
}