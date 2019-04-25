<?php
require_once('Middleware.php');

class ThrottlingMiddleware extends Middleware
{
    private $currentTime;
    private $howManyRequests;
    private $maximumRequestsPerMinute;

    /**
     * ThrottlingMiddleware constructor.
     * @param int $maximumRequestsPerMinute
     */
    public function __construct($maximumRequestsPerMinute = 1)
    {
        $this->maximumRequestsPerMinute = $maximumRequestsPerMinute;
        $this->currentTime = time();
    }

    /**
     * Please, note that the parent::check call can be inserted both at the
     * beginning of this method and at the end.
     *
     * This gives much more flexibility than a simple loop over all middleware
     * objects. For instance, a middleware can change the order of checks by
     * running its check after all the others.
     * @param $email
     * @param $password
     * @return bool
     */
    public function check($email, $password)
    {
        if (time() > $this->currentTime + 60){
            $this->howManyRequests = 0;
            $this->currentTime = time();
        }
        $this->howManyRequests++;
        if ($this->howManyRequests > $this->maximumRequestsPerMinute)
        {
            echo "ThrottlingMiddleware: Too many requests per minute\n";
            die();
        }
        return parent::check($email, $password); // TODO: Change the autogenerated stub
    }
}