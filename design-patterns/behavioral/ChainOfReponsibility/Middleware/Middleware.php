<?php

/**
 * THe base class of the chain
 * Class Middleware
 */
class Middleware
{
    private $next;

    /**
     * This method is used to build a chain of middleware objects
     * @param Middleware $next
     * @return Middleware
     */
    public function linkWith(Middleware $next){
        $this->next = $next;
        return $next;
    }

    /**
     * Subclasses must override this method to perform their own checks.
     * If a subclass can't process the request, it can fall back on the
     * parent implementation
     * @param $email
     * @param $password
     * @return bool
     */
    public function check($email, $password){
        if (!$this->next) {
            return true;
        }

        return $this->next->check($email, $password);
    }
}